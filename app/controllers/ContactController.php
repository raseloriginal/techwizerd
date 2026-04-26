<?php
class ContactController extends Controller
{
    public function index(): void
    {
        $this->requireLogin();
        $contactModel = new Contact();
        $messages     = $contactModel->getAll();
        $flash        = flash();
        $this->view('admin/contacts/index', compact('messages', 'flash'), 'admin');
    }

    public function markRead(string $id): void
    {
        $this->requireLogin();
        $contactModel = new Contact();
        $contactModel->markRead((int)$id);
        $this->redirect(BASE_URL . 'admin/contacts');
    }

    public function delete(string $id): void
    {
        $this->requireLogin();
        $contactModel = new Contact();
        $contactModel->delete('contact_messages', ['id' => (int)$id]);
        set_flash('success', 'Message deleted.');
        $this->redirect(BASE_URL . 'admin/contacts');
    }
}
