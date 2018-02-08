<div class="hidden">
    <?php
    if(count($errors) > 0){
        foreach($errors->all() as $error){?>
            <div class="grey-background">
                <div class="container">
                    <div class="alert alert-danger m-b-0 p-b-10">
                        <?=$error?>
                    </div>
                </div>
            </div>
        <? } ?>
    <? } ?>

    @if(session('success'))
        <div class="grey-background">
            <div class="container grey-background">
                <div class="alert alert-success m-b-0 p-b-10">
                    {{session('success')}}
                </div>
            </div>
        </div>
    @endif
</div>