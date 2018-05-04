<?php

if(count($errors) > 0) {
     foreach($errors->all() as $error){ ?>
        <div class="alert alert-danger m-b-0 p-b-10 m-t-15">
            <p class="c-orange text-center"><?=$error?></p>
        </div>
    <? } ?>
<? } ?>

@if(session('success'))
    <div class="alert alert-success m-b-0 p-b-10 m-t-15">
        {{session('success')}}
    </div>
@endif