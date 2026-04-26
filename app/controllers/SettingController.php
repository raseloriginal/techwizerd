<?php
class SettingController extends Controller
{
    public function index(): void
    {
        $this->requireLogin();
        $settingModel = new Setting();
        $settings     = $settingModel->getAll();
        $flash        = flash();
        $this->view('admin/settings/index', compact('settings', 'flash'), 'admin');
    }

    public function update(): void
    {
        $this->requireLogin();
        if (!$this->csrfCheck()) {
            set_flash('error', 'Invalid CSRF token.');
            $this->redirect(BASE_URL . 'admin/settings');
            return;
        }

        $settingModel = new Setting();
        $allowed = [
            'site_title', 'site_tagline', 'site_email', 'site_phone',
            'site_phone2', 'site_address', 'site_description',
            'facebook_url', 'linkedin_url', 'google_map_embed',
        ];

        foreach ($allowed as $key) {
            if (isset($_POST[$key])) {
                $settingModel->set($key, $this->sanitize($_POST[$key]));
            }
        }

        set_flash('success', 'Settings saved successfully!');
        $this->redirect(BASE_URL . 'admin/settings');
    }
}
