<?php

namespace App\Controllers;

use App\Models\UserModel;
use CodeIgniter\Exceptions\PageNotFoundException;

class UserController extends BaseController
{
    public function index()
    {
        $model = new UserModel();

        return view('users/index', [
            'users' => $model
                ->orderBy('created_at', 'DESC')
                ->findAll()
        ]);
    }

    public function createForm()
    {
        helper('form');
        return view('users/form', [
            'title' => 'Add Staff User',
            'user' => null
        ]);
    }

    public function create()
    {
        $rules = [
            'username' => 'required|alpha_numeric|min_length[3]|max_length[50]|is_unique[users.username]',
            'full_name' => 'required|min_length[2]|max_length[100]',
            'password' => 'required|min_length[8]|max_length[255]',
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()->withInput();
        }

        $avatar = $this->uploadAvatar();

        if ($avatar === false) {
            return redirect()->back()->withInput();
        }

        $model = new UserModel();

        $model->insert([
            'username' => trim($this->request->getPost('username')),
            'full_name' => trim($this->request->getPost('full_name')),
            'password' => password_hash(
                $this->request->getPost('password'),
                PASSWORD_DEFAULT
            ),
            'avatar' => $avatar,
            'created_at' => date('Y-m-d H:i:s'),
        ]);

        return redirect()
            ->to('/users')
            ->with('message', 'Staff user added successfully.');
    }

    public function edit(int $id)
    {
        helper('form');
        $user = (new UserModel())->find($id);

        if (! $user) {
            throw PageNotFoundException::forPageNotFound(
                'User not found.'
            );
        }

        return view('users/form', [
            'title' => 'Edit Staff User',
            'user' => $user
        ]);
    }

    public function update(int $id)
    {
        $model = new UserModel();

        if (! $model->find($id)) {
            throw PageNotFoundException::forPageNotFound(
                'User not found.'
            );
        }

        $rules = [
            'username' => "required|alpha_numeric|min_length[3]|max_length[50]|is_unique[users.username,id,{$id}]",
            'full_name' => 'required|min_length[2]|max_length[100]',
            'password' => 'permit_empty|min_length[8]|max_length[255]',
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()->withInput();
        }

        $data = [
            'username' => trim($this->request->getPost('username')),
            'full_name' => trim($this->request->getPost('full_name')),
        ];

        $password = $this->request->getPost('password');

        if (! empty($password)) {
            $data['password'] = password_hash(
                $password,
                PASSWORD_DEFAULT
            );
        }

        $avatar = $this->uploadAvatar();

        if ($avatar === false) {
            return redirect()->back()->withInput();
        }

        if ($avatar !== null) {
            $data['avatar'] = $avatar;
        }

        $model->update($id, $data);

        return redirect()
            ->to('/users')
            ->with('message', 'Staff user updated successfully.');
    }

    public function delete(int $id)
    {
        if ((int) session()->get('user_id') === $id) {
            return redirect()
                ->to('/users')
                ->with('error', 'You cannot delete your current account.');
        }

        (new UserModel())->delete($id);

        return redirect()
            ->to('/users')
            ->with('message', 'Staff user deleted successfully.');
    }

    private function uploadAvatar(): string|false|null
    {
        $file = $this->request->getFile('avatar');

        if (! $file || $file->getError() === UPLOAD_ERR_NO_FILE) {
            return null;
        }

        $rules = [
            'avatar' =>
                'uploaded[avatar]' .
                '|is_image[avatar]' .
                '|mime_in[avatar,image/jpg,image/jpeg,image/png,image/webp]' .
                '|max_size[avatar,2048]'
        ];

        if (! $this->validateData([], $rules)) {
            return false;
        }

        $newName = $file->getRandomName();
        $uploadPath = FCPATH . 'uploads';

        if (! is_dir($uploadPath)) {
            mkdir($uploadPath, 0775, true);
        }

        $file->move($uploadPath, $newName);

        service('image')
            ->withFile($uploadPath . DIRECTORY_SEPARATOR . $newName)
            ->fit(300, 300, 'center')
            ->save($uploadPath . DIRECTORY_SEPARATOR . $newName);

        return $newName;
    }
}