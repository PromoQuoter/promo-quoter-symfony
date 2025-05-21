<?php
/**
 * @var View $this
 */

use CodeIgniter\View\View;

$this->extend('_layouts_/home');
?>

<?= $this->section('content') ?>
<script src="https://www.google.com/recaptcha/api.js" async defer></script>
    <section class="main-sec">
        <div class="container d-flex justify-content-center p-5">
            <div class="card col-12 col-md-6 shadow-sm">
                <div class="card-body">
                    <div class="mb-3">
                        <h5 class="card-title"><?= lang('Auth.login') ?></h5>
                        <span class="text-muted">Sign in to your account.</span>
                    </div>

                    <form action="<?= url_to('login') ?>" method="post">
                        <?= csrf_field() ?>

                        <?php if (session('error') !== null) : ?>
                            <div class="alert alert-danger" role="alert"><?= session('error') ?></div>
                        <?php elseif (session('errors') !== null) : ?>
                            <div class="alert alert-danger" role="alert">
                                <?php if (is_array(session('errors'))) : ?>
                                    <?php foreach (session('errors') as $error) : ?>
                                        <?= $error ?>
                                        <br>
                                    <?php endforeach ?>
                                <?php else : ?>
                                    <?= session('errors') ?>
                                <?php endif ?>
                            </div>
                        <?php endif ?>

                        <?php if (session('message') !== null) : ?>
                            <div class="alert alert-success" role="alert"><?= session('message') ?></div>
                        <?php endif ?>

                        <!-- Email -->
                        <div class="input-group mb-2">
                            <span class="input-group-text">
                                <i class="fa fa-user fa-fw"></i>
                            </span>
                            <input type="text" class="form-control" name="email"
                                   autocomplete="email"
                                   placeholder="Email" value="<?= old('email') ?>"
                                   required/>
                        </div>

                        <!-- Password -->
                        <div class="input-group mb-2">
                            <span class="input-group-text">
                                <i class="fa fa-key fa-fw"></i>
                            </span>
                            <input type="password" class="form-control" name="password" inputmode="text"
                                   autocomplete="current-password" placeholder="<?= lang('Auth.password') ?>"
                                   required/>
                        </div>

                        <!-- Remember me -->
                        <?php if (setting('Auth.sessionConfig')['allowRemembering']): ?>
                            <div class="mb-2 form-check">
                                <input type="checkbox" name="remember" id="remember"
                                       class="form-check-input" <?php if (old('remember')): ?> checked<?php endif ?>>
                                <label class="form-check-label"
                                       for="remember"><?= lang('Auth.rememberMe') ?></label>
                            </div>
                        <?php endif ?>
                        <div class="col-md-12 mb-3" style="display: flex; justify-content: center;">

                        <div class="g-recaptcha" data-sitekey="6LcR4HwpAAAAACiB5BGzciqL5RvRCWRgT6OUGYK-" data-required="true"></div>
                        </div>
                        <button type="submit" class="btn btn-promo w-100"><?= lang('Auth.login') ?></button>

                        <!-- Divider -->
                        <hr class="my-3">

                        <p class="text-center m-0 text-secondary">
                            <?= lang('Auth.forgotPassword') ?>
                            <a class="text-decoration-none"  href="<?= url_to('magic-link') ?>"><?= lang('Auth.useMagicLink') ?></a>

                            <?php if (setting('Auth.allowRegistration')) : ?>
                                &bullet;
                                <?= lang('Auth.needAccount') ?>
                                <a class="text-decoration-none" href="<?= url_to('register') ?>"><?= lang('Auth.register') ?></a>
                            <?php endif ?>
                        </p>
                    </form>
                </div>
            </div>
        </div>
    </section>
<?= $this->endSection() ?>