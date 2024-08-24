<?php

class ProfileView extends View
{
    public function render($view, $data = [])
    {
        extract($data);
        $content = $this->getContent($this->viewPath . 'users/profile/' . $view . '.php', $data);
        $data['content'] = $content;
        $data['page'] = $view;
        $content = $this->getContent($this->viewPath . 'users/profile/profile_page_template.php', $data);
        include $this->viewPath . 'layouts/template.php';
    }
}

?>