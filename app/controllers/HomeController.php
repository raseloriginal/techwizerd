<?php
class HomeController extends Controller
{
    public function index(): void
    {
        $serviceModel = new Service();
        $clientModel  = new Client();
        $projectModel = new Project();
        $teamModel    = new Team();

        $services         = $serviceModel->getActive(4);
        $clients          = $clientModel->getActive();
        $featuredProjects = $projectModel->getFeatured(3);
        $leaders          = $teamModel->getLeaders(4);

        $this->view('home/index', compact('services', 'clients', 'featuredProjects', 'leaders'));
    }

    public function about(): void
    {
        $settingModel = new Setting();
        $settings     = $settingModel->getAll();
        $this->view('about/index', compact('settings'));
    }

    public function services(): void
    {
        $serviceModel = new Service();
        $services     = $serviceModel->getActive();
        $this->view('services/index', compact('services'));
    }

    public function team(): void
    {
        $teamModel = new Team();
        $grouped   = $teamModel->getGroupedByDepartment();
        $this->view('team/index', compact('grouped'));
    }

    public function contact(): void
    {
        $flash = flash();
        $this->view('contact/index', compact('flash'));
    }

    public function submitContact(): void
    {
        if (!$this->csrfCheck()) {
            set_flash('error', 'Invalid request. Please try again.');
            $this->redirect(BASE_URL . 'contact');
            return;
        }

        $name    = $this->sanitize($_POST['name'] ?? '');
        $email   = filter_var($_POST['email'] ?? '', FILTER_SANITIZE_EMAIL);
        $phone   = $this->sanitize($_POST['phone'] ?? '');
        $subject = $this->sanitize($_POST['subject'] ?? '');
        $message = $this->sanitize($_POST['message'] ?? '');

        if (empty($name) || empty($message)) {
            set_flash('error', 'Name and message are required.');
            $this->redirect(BASE_URL . 'contact');
            return;
        }

        $contactModel = new Contact();
        $contactModel->insert('contact_messages', [
            'name'    => $name,
            'email'   => $email,
            'phone'   => $phone,
            'subject' => $subject,
            'message' => $message,
            'is_read' => 0,
        ]);

        set_flash('success', 'Thank you! Your message has been received. We will contact you shortly.');
        $this->redirect(BASE_URL . 'contact');
    }
}
