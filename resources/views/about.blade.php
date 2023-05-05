@extends('layouts.default')

@section('content')
<section class="about-section pt-5 mt-3">
    <div class="container">
        <div class="row align-items-center flex-lg-row-reverse">
            <div class="col-lg-6 mb-5 mb-lg-0 col-sm-9 ps-xl-5">
                <img src="images/thumb/nft-img-2.png" alt="" class="img-fluid">
            </div><!-- end col-lg-6 -->
            <div class="col-lg-6 pe-lg-5">
                <div class="section-content-block">
                    <h2 class="mb-4">Building an open digital economy</h2>
                    <p class="mb-3">At EnftyMart, we're excited about a brand new type of digital good called a non-fungible token, or NFT. NFTs have exciting new properties: they’re unique, provably scarce, tradeable, and usable across multiple applications. Just like physical goods, you can do whatever you want with them! You could throw them in the trash, gift them to a friend a</p>
                    <p class="mb-3">A core part of our vision is that open protocols like Ethereum and interoperable standards like ERC-721 and ERC-1155 will enable vibrant new economies. We're building tools that allow consumers to trade their assets freely</p>
                    <p>We’re proud to be the first and largest marketplace for NFTs.</p>
                </div>
            </div><!-- end col-lg-6 -->
        </div><!-- end row -->
    </div><!-- end container -->
</section><!-- end about-section -->
<section class="cta-section section-space-b bg-pattern mt-5">
    <div class="container">
        <div class="cta-box text-center">
            <h1 class="cta-title mb-3">Interested in joining us?</h1>
            <p class="cta-text mb-4">Hop aboard and view our open positions</p>
            <a href="contact.html" class="btn btn-lg btn-dark">See open roles</a>
        </div><!-- end cta-box -->
    </div><!-- .container -->
</section><!-- end cta-section -->
@endsection
