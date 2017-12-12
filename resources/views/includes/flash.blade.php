<?php
if(count($errors) > 0){
    foreach($errors->all() as $error){?>
    <div class="container">
        <div class="alert alert-danger">
            <?=$error?>
        </div>
    </div>
    <? } ?>
<? } ?>

@if(session('success'))
    <div class="container">
        <div class="alert alert-success">
            {{session('success')}}
        </div>
    </div>
@endif