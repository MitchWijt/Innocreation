@section("footer")
<footer>
    <div class="footer d-flex p-t-20 p-b-20">
        <div class="footer-title text-center">
            <h1 class="title" style="color: #C9CCCF">Inn<img class="cartwheelLogo" src="/images/cartwheel.png" alt="">creation</h1>
            <a class="td-none" href="/login"><p class="instructions-text create-account">Create your account</p></a>
        </div>
        <div class="d-flex">
            <div class="d-flex list-links">
                <p class="regular-link td-none m-0">Find us on:</p>
                <a class="regular-link c-gray" href="">Facebook</a>
                <a class="regular-link c-gray" href="">Instagram</a>
                <a class="regular-link c-gray" href="">Twitter</a>
            </div>
        </div>
        <div class="d-flex">
            <div class="d-flex list-links">
                <p class="regular-link td-none m-0">General info:</p>
                <a class="regular-link c-gray" href="/contact-us">Contact</a>
                <a class="regular-link c-gray" href="/faq">FAQ</a>
                <a class="regular-link c-gray" href="">Terms of agreement</a>
                <? if(\Illuminate\Support\Facades\Session::has("user_id")) { ?>
                    <a class="regular-link c-gray" href="/platform-idea">Idea? Let us know!</a>
                <? } ?>
            </div>
        </div>
        <div class="d-flex">
            <div class="d-flex list-links">
                <p class="regular-link td-none m-0">The platform:</p>
                <a class="regular-link c-gray" href="/page/what-is-innocreation">What is Innocreation?</a>
                {{--<a class="regular-link c-gray" href="">People behind Innocreation</a>--}}
                <a class="regular-link c-gray" href="/pricing">Pricing</a>
                <a class="regular-link c-gray" href="/page/our-motivation">Our motivation</a>
            </div>
        </div>
    </div>
</footer>