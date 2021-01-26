
 <div class="row">
     <div class="col-lg-3">
         <?= $form->field($model, 'postcode')->textInput() ?>
     </div>
     <div class="col-lg-3">
         <?= $form->field($model, 'city')->textInput(['maxlength' => true]) ?>
     </div>
     <div class="col-lg-4">
         <?= $form->field($model, 'street')->textInput(['maxlength' => true]) ?>
     </div>
     <div class="col-lg-1">
         <?= $form->field($model, 'house')->textInput(['maxlength' => true]) ?>
     </div>
     <div class="col-lg-1">
         <?= $form->field($model, 'apartment')->textInput(['maxlength' => true]) ?>
     </div>
 </div>









