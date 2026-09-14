<?php

namespace App\Controllers;

use App\Models\UserModel;
use CodeIgniter\Exceptions\PageNotFoundException;
use Throwable;

class UserController extends BaseController
{
    protected UserModel $userModel;

    public function __construct()
    {
        helper(['form', 'url']);

        $this->userModel = new UserModel();
    }

    public function index()
    {
        return view('users/index', [
            'users' => $this->userModel
                ->orderBy('id', 'DESC')
                ->findAll(),
        ]);
    }

    public function create()
    {
        return view('users/create');
    }

    public function store()
    {
        $rules = [
            'username' => 'required|max_length[50]|is_unique[users.username]',
            'full_name' => 'required|max_length[100]',
            'password' => 'required|min_length[8]|max_length[255]',
            'avatar' => [
                'rules' => [
                    'permit_empty',
                    'is_image[avatar]',
                    'mime_in[avatar,image/jpg,image/jpeg,image/png,image/webp]',
                    'max_size[avatar,2048]',
                ],
            ],
        ];

        if (! $this->validate($rules)) {
            return redirect()
                ->back()
                ->withInput()
                ->with('errors', $this->validator->getErrors());
        }

        $avatarName = $this->uploadAvatar();

        $this->userModel->insert([
            'username'   => trim((string) $this->request->getPost('username')),
            'full_name'  => trim((string) $this->request->getPost('full_name')),
            'password'   => password_hash(
                (string) $this->request->getPost('password'),
                PASSWORD_DEFAULT
            ),
            'avatar'     => $avatarName,
            'created_at' => date('Y-m-d H:i:s'),
        ]);

        return redirect()
            ->to('/users')
            ->with('success', 'Staff account added successfully.');
    }

    public function edit(int $id)
    {
        return view('users/edit', [
            'user' => $this->findUser($id),
        ]);
    }

    public function update(int $id)
    {
        $user = $this->findUser($id);

        $rules = [
            'username' => "required|max_length[50]|is_unique[users.username,id,{$id}]",
            'full_name' => 'required|max_length[100]',
            'password' => 'permit_empty|min_length[8]|max_length[255]',
            'avatar' => [
                'rules' => [
                    'permit_empty',
                    'is_image[avatar]',
                    'mime_in[avatar,image/jpg,image/jpeg,image/png,image/webp]',
                    'max_size[avatar,2048]',
                ],
            ],
        ];

        if (! $this->validate($rules)) {
            return redirect()
                ->back()
                ->withInput()
                ->with('errors', $this->validator->getErrors());
        }

        $data = [
            'username'  => trim((string) $this->request->getPost('username')),
            'full_name' => trim((string) $this->request->getPost('full_name')),
        ];

        $password = (string) $this->request->getPost('password');

        if ($password !== '') {
            $data['password'] = password_hash(
                $password,
                PASSWORD_DEFAULT
            );
        }

        $avatarName = $this->uploadAvatar();

        if ($avatarName !== null) {
            $data['avatar'] = $avatarName;
            $this->deleteAvatarFile($user['avatar'] ?? null);
        }

        $this->userModel->update($id, $data);

        if ((int) session()->get('user_id') === $id) {
            session()->set([
                'username'  => $data['username'],
                'full_name' => $data['full_name'],
            ]);
        }

        return redirect()
            ->to('/users')
            ->with('success', 'Staff account updated successfully.');
    }

    public function delete(int $id)
    {
        $user = $this->findUser($id);

        if ((int) session()->get('user_id') === $id) {
            return redirect()
                ->to('/users')
                ->with('error', 'You cannot delete your own account.');
        }

        try {
            $this->userModel->delete($id);
        } catch (Throwable $exception) {
            return redirect()
                ->to('/users')
                ->with(
                    'error',
                    'This staff account cannot be deleted because it is connected to an existing sale.'
                );
        }

        $this->deleteAvatarFile($user['avatar'] ?? null);

        return redirect()
            ->to('/users')
            ->with('success', 'Staff account deleted successfully.');
    }

    private function findUser(int $id): array
    {
        $user = $this->userModel->find($id);

        if (! $user) {
            throw PageNotFoundException::forPageNotFound(
                'Staff account not found.'
            );
        }

        return $user;
    }

    private function uploadAvatar(): ?string
    {
        $avatar = $this->request->getFile('avatar');

        if (
            ! $avatar ||
            ! $avatar->isValid() ||
            $avatar->hasMoved()
        ) {
            return null;
        }

        $uploadPath = FCPATH . 'uploads/avatars';

        if (! is_dir($uploadPath)) {
            mkdir($uploadPath, 0775, true);
        }

        $newName = $avatar->getRandomName();
        $avatar->move($uploadPath, $newName);

        return $newName;
    }

    private function deleteAvatarFile(?string $avatarName): void
    {
        if (! $avatarName) {
            return;
        }

        $avatarPath = FCPATH . 'uploads/avatars/' . $avatarName;

        if (is_file($avatarPath)) {
            unlink($avatarPath);
        }
    }
}