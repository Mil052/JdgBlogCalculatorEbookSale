@props (['title', 'excerpt', 'created_at', 'id', 'author'])

<div style="background-image: url(/storage/working-group.webp)" class="bg-no-repeat bg-right relative">
    <div style="background-image: url(/storage/paper.svg)" class="bg-no-repeat h-full xs:w-9/10 sm:w-4/5 bg-right">
        <div class="min-h-screen px-4 py-16 lg:px-8 flex flex-col gap-12 justify-between">
            <h1 class="w-4/5 my-4 sm:my-8 font-technic text-base">
                Wszystko co musisz wiedzieć prowadząc Jednoosobową Działalność Gospodarczą.
            </h1>
            <div class="p-4 lg:w-[calc(100%_-_240px)] bg-white lg:bg-[unset] rounded-sm shadow-[6px_6px_6px_#00000040] lg:shadow-none">
                <h3 class="font-technic text-sm sm:text-base">Nowy post! Zapraszamy do czytania.</h3>
                <div>
                    <h2 class="font-title text-2xl sm:text-4xl my-6">{{ $title }}</h2>
                    <p class="lg:w-4/5 font-paragraph text-sm xs:text-base sm:text-lg lg:text-xl xl:text-2xl my-6">
                        {{ $excerpt }}
                    </p>
                    <div class="lg:w-4/5 font-technic text-sm sm:text-base flex justify-between my-2">
                        <address class="author font-light">{{ $author }}</address>
                        <h3>{{ $created_at }}</h3>
                    </div>
                </div>
                <a href="/blog/{{ $id }}" class="font-technic text-sea-dark">
                    przejdź do artykułu
                    <span class="text-xl/5">&#8594;</span>
                </a>
            </div>
        </div>
    </div>
    <a href="https://www.pexels.com/photo/group-of-men-and-women-working-together-7693740" class="absolute bottom-4 right-4 text-xs">
        photo by Yan Krukau on pexels.com
    </a>
</div>