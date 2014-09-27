<html>
    <body>
        <header>
            <h1>{{ $article->title }}</h1>
        </header>
        <hr/>
        <section>
            {{ $article->body }}
        </section>
        <section style="text-align: center;width: 100%">
            @if ($article->image)
                <img src="{{ $article->image }}"/>
            @endif
        </section>
    </body>
</html>