<?php
/**
 * Template Name: Account Page
 *
 * @package Bootscore
 */

 
get_header("myaccount"); // Вставляем заголовок сайта

?>
<main class="main my-3 mt-md-0 registration-form">
    <div class="container">
      <div class="row justify-content-center pt-2 pb-3">
        <div class="col-md-4">
            <?php include get_stylesheet_directory() . '/woocommerce/myaccount/my-account-offcanvas.php'; ?>
          <h5 class="fw-bold text-center mb-2">Регистрация</h5>
          <form>
            <div class="mb-3">
              <input class="form-control" type="text" placeholder="Логин, ник игрока, телефон, email">
            </div>
            <div class="mb-3">
              <input class="form-control" type="email" placeholder="Email">
            </div>
            <div class="mb-3 input-group">
              <input class="form-control password-eye" type="password" placeholder="Пароль" aria-describedby="togglePassword"><span class="input-group-text" role="button"><i class="fa-regular fa-eye-slash" id="togglePassword"></i></span>
            </div>
            <div class="mb-3">
              <input class="form-control" type="password" placeholder="Подтвердить пароль" aria-describedby="togglePassword">
            </div>
            <div class="d-block text-center">
              <button class="btn btn-primary" type="submit">Регистрация</button>
            </div>
          </form>
        </div>
      </div>
    </div>
</main>


