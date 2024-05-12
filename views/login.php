<h1>Login</h1>

<?php $form = \app\core\form\Form::begin('', 'post') ?>

<?php echo $form->field($model, 'email', 'email') ?>
<?php echo $form->field($model, 'password', 'password') ?>

<button type="submit" class="btn btn-primary">Submit</button>

<?php echo \app\core\form\Form::end() ?>