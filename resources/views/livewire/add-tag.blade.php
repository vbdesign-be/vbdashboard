<div>
    <!-- Tag toevoegen -->
    <form method="post" action="/ticket/addTag">
        @csrf
        <input class="border" type="text" name="tag" value="">
        <input type="hidden" value="{{$ticket_id}}" name="ticket_id">
        <button>Tag toevoegen</button>
    </form>
</div>
