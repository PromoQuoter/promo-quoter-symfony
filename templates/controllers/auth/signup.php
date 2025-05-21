<?php
/**
 * @var View $this
 */

use App\Entities\CompanyInvites;
use App\Models\CompanyInvitesModel;
use App\Models\CompanyModel;
use CodeIgniter\View\View;
use function App\Helpers\get_url;

$this->extend('_layouts_/home');

$companyInvitesModel = model(CompanyInvitesModel::class);
if ($inviteId = session()->get('_pq_invite_id')) {
    /** @var CompanyInvites $invite */
    $invite = $companyInvitesModel->find($inviteId);
}
?>

<?= $this->section('content') ?>
<script src="https://www.google.com/recaptcha/api.js" async defer></script>
    <section class="main-sec">
        <div class="container d-flex justify-content-center p-5">
            <div class="card col-12 col-md-6 shadow-sm">
                <div class="card-body">
                    <div class="mb-3">
                        <h5 class="card-title"><?= lang('Auth.register') ?></h5>
                        <span class="text-muted">Sign up for a new account.</span>
                    </div>

                    <?php if (isset($invite)) : ?>
                        <?php
                        $companyModel = model(CompanyModel::class);
                        $company = $companyModel->find($invite->company_id);
                        ?>

                        <div class="alert alert-info" role="alert">
                            <i class="fa fa-fw fa-info-circle"></i>
                            You have been invited to join
                            <strong><?= esc($company->name ?? 'Unknown Company') ?></strong>.<br/>
                            Not the company you want to join? <a href="<?= get_url('invalidate-company-invite') ?>">Sign
                                up for a new account</a>.
                        </div>
                    <?php endif ?>

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

                    <form action="<?= url_to('register') ?>" method="post">
                        <?= csrf_field() ?>

                        <div class="row g-3">
                            <!-- Username -->
                            <div class="col-md-6">
                                <div class="input-group">
                                    <span class="input-group-text">
                                        <i class="fa fa-fw fa-user"></i>
                                    </span>
                                    <input type="text" class="form-control" name="username"
                                           placeholder="<?= lang('Auth.username') ?>" value="<?= old('username') ?>"
                                           autocomplete="username" required/>
                                </div>
                            </div>

                            <!-- Email -->
                            <div class="col-md-6">
                                <div class="input-group">
                                    <span class="input-group-text">
                                        <i class="fa fa-fw fa-envelope"></i>
                                    </span>
                                    <input type="email" class="form-control" name="email" inputmode="email"
                                           autocomplete="email" placeholder="<?= lang('Auth.email') ?>"
                                           value="<?= isset($invite) ? $invite->email : old('email') ?>"
                                           required
                                           <?php if (isset($invite)) : ?>readonly<?php endif ?>
                                    />
                                </div>
                            </div>

                            <!-- Password -->
                            <div class="col-md-6">
                                <div class="input-group">
                                    <span class="input-group-text">
                                        <i class="fa fa-fw fa-key"></i>
                                    </span>
                                    <input type="password" class="form-control" name="password"
                                           autocomplete="new-password" placeholder="<?= lang('Auth.password') ?>"
                                           required/>
                                </div>
                            </div>

                            <!-- Confirm Password -->
                            <div class="col-md-6">
                                <div class="input-group">
                                    <span class="input-group-text">
                                        <i class="fa fa-fw fa-key"></i>
                                    </span>
                                    <input type="password" class="form-control" name="password_confirm"
                                           autocomplete="new-password" placeholder="<?= lang('Auth.passwordConfirm') ?>"
                                           required/>
                                </div>
                            </div>

                            <?php if (!isset($invite)) : ?>
                                <!-- Organization -->
                                <div class="col-md-6">
                                    <div class="input-group">
                                        <span class="input-group-text">
                                            <i class="fa fa-fw fa-suitcase"></i>
                                        </span>
                                        <input type="text" class="form-control" name="company"
                                               placeholder="<?= lang('Auth.company') ?>" value="<?= old('company') ?>"
                                               required/>
                                    </div>
                                </div>

                                <!-- Phone -->
                                <div class="col-md-6">
                                    <div class="input-group">
                                        <span class="input-group-text">
                                            <i class="fa fa-fw fa-phone"></i>
                                        </span>
                                        <input type="text" class="form-control" name="phone"
                                               placeholder="<?= lang('Auth.phone') ?>" value="<?= old('phone') ?>"
                                               required/>
                                    </div>
                                </div>
                            <?php endif ?>

                            <!-- Accept terms -->
                            <div class="col-md-12">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="accept_terms"
                                           id="accept_terms" required/>
                                    <label class="form-check-label" for="accept_terms">
                                        I agree to the <a href="/terms-and-conditions">Terms of Service</a> &amp; <a
                                                href="/privacy-policy">Privacy Policy</a>
                                    </label>
                                </div>
                            </div>

                            <div class="col-md-12 mb-3" style="display: flex; justify-content: center;">
                                 <div class="g-recaptcha" data-sitekey="6LcR4HwpAAAAACiB5BGzciqL5RvRCWRgT6OUGYK-"></div>
                            </div>
                            
                            <div class="col-md-12">
                                <button type="submit" class="btn btn-promo w-100">Register</button>
                            </div>

                            <!-- Divider -->
                            <hr class="my-3" />

                            <p class="text-center m-0 text-secondary">
                                <?= lang('Auth.haveAccount') ?>
                                <a class="text-decoration-none"  href="<?= url_to('login') ?>"><?= lang('Auth.login') ?></a>
                            </p>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
<?= $this->endSection() ?>