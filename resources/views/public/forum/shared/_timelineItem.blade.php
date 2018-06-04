<?
        $counterThreads = 0;
        $counterThreadComments = 0;
?>
<? foreach($forumThreads as $forumThread) { ?>
    <?
        if ($counterThreads % 2 == 0) {
            echo "<li>";
        } else {
            echo "<li class='timeline-inverted'>";
        }
    ?>
        <div class="timeline-badge border-default"><i class="zmdi zmdi-account-box-mail"></i></div>
        <div class="timeline-panel">
            <div class="timeline-heading @desktop d-flex @enddesktop">
                <img class="circle circleImage" src="<?= $forumThread->creator->getProfilePicture()?>" alt="">
                <p class="timeline-title f-16 m-t-10"><a href="<?= $forumThread->creator->getUrl()?>" class="regular-link" target="_blank"><?= $forumThread->creator->firstname?></a> created a new thread in: <br>
                    <a href="<?= $forumThread->forumMainTopic->First()->getUrl()?>" class="regular-link"><?= $forumThread->forumMainTopic->First()->title?></a></p>
            </div>
            <div class="timeline-body">
            </div>
        </div>
    </li>
    <? $counterThreads++?>
<? } ?>
<? foreach($forumThreadComments as $forumThreadComment) { ?>
    <?
    if ($counterThreadComments % 2 == 0) {
        echo "<li>";
    } else {
        echo "<li class='timeline-inverted'>";
    }
    ?>
        <div class="timeline-badge border-default"><i class="zmdi zmdi-comments"></i></div>
        <div class="timeline-panel">
            <div class="timeline-heading @desktop d-flex @enddesktop">
                <img class="circle circleImage" src="<?= $forumThreadComment->creator->getProfilePicture()?>" alt="">
                <p class="timeline-title f-16 m-t-10"><a href="<?= $forumThreadComment->creator->getUrl()?>" class="regular-link" target="_blank"><?= $forumThreadComment->creator->firstname?></a> posted a comment in thread: <br>
                    <a href="<?= $forumThreadComment->thread->First()->getUrl()?>" class="regular-link"><?= $forumThreadComment->thread->First()->title?></a></p>
            </div>
            <div class="timeline-body">
            </div>
        </div>
    </li>
    <? $counterThreadComments++?>
<? } ?>
