<header>
    <nav class="navbar navbar-default navbar-static-top">
        <div class="container">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                    <span class="sr-only">Toggle Navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a href="/" class="navbar-left"><img src="{{ secure_asset("images/logo.png") }}" alt="Monolist"></img></a>
            </div>
            <div class="collapse navnar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav　navbar-nav navbar-right">
                    <li><a href="{{ route('signup.get') }}">新規登録</a></li>
                    <li><a href="#">ログイン</a></li>
                    
                </ul>
            </div>
        </div>
    </nav>
</header>