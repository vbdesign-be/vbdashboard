<div class="my-4">
    <ul >
        @foreach($tickets_tags as $t)
        <li class="tag flex gap-4"><p>{{$t->tag->name}}</p><a class="deleteTagBtn" wire:click="deleteTag({{$t->id}})" href="">remove btn</a></li>
        @endforeach
    </ul>
</div>

<script>
    let tags = document.querySelectorAll('.tag');
    tags.forEach((tag) => {
        let deleteTagBtn = tag.querySelector('.deleteTagBtn');
        deleteTagBtn.addEventListener('click', (e) => {
            e.preventDefault();
        })
    })
</script>


