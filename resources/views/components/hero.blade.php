@props (['title', 'excerpt', 'created_at', 'id', 'author'])

<div style="background-image: url(/storage/working-group.webp)" class="h-screen bg-no-repeat bg-right relative">
    <div style="background-image: url(/storage/paper.svg)" class="bg-no-repeat h-full w-4/5 bg-right">
        <div class="h-full p-8 flex flex-col justify-between">
            <h1 class="my-16 font-technic">
                Wszystko co musisz wiedzieć prowadząc Jedno Osobową Działalność Gospodarczą.
            </h1>
            <div class="">
                <h3 class="font-technic">Nowy post! Zapraszamy do czytania.</h3>
                <div>
                    <h2 class="font-title text-4xl my-6">{{ $title }}</h2>
                    <p class="font-paragraph text-2xl my-6">{{ $excerpt }}</p>
                    <div class="font-technic flex justify-between my-6">
                        <h3>{{ $author }}</h3>
                        <h3>{{ $created_at }}</h3>
                    </div>
                    <a href="#">przejdź do artykułu</a>
                </div>
        </div>
        </div>
    </div><!-- Nothing worth having comes easy. - Theodore Roosevelt -->
    <a href="https://www.pexels.com/photo/group-of-men-and-women-working-together-7693740" class="absolute bottom-4 right-4 text-xs">
        photo by Yan Krukau on pexels.com
    </a>
</div>