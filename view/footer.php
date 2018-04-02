<footer>
    <hr />
    <p>Copyright &copy; 2017 - Emil Sandberg</p>

    <?php if ($this->di->session->has("username")) : ?>
        <p>
            <a href="<?= $this->url('logout') ?>">Logga ut</a>
            | <a href="<?= $this->url('user') ?>">Konto</a>
            <?php if ($this->di->session->has("admin")) : ?>
                | <a href="<?= $this->url('admin') ?>">Admin</a>                
            <?php endif; ?>
        </p>
    <?php else : ?>
        <p><a href="<?= $this->url('login') ?>">Logga in</a> | <a href="<?= $this->url('register') ?>">Registrera ny användare</a></p>
    <?php endif; ?>
</footer>
