<section class="py-8">
          <div class="container px-4 mx-auto">
            <div class="bg-white shadow rounded py-6 px-6">
              <p>notitie toevoegen</p>
              <form wire:submit.prevent="updateNote">
              @csrf
                <textarea wire:model="textNote" class="w-full border p-5" name="note" rows="5" placeholder="">{{$notitie->text}}</textarea>
                <div class="flex justify-end mt-6">
                <button class="inline-block w-full md:w-auto px-6 py-3 font-medium text-white bg-indigo-500 hover:bg-indigo-600 rounded transition duration-200" type="submit">Update note</button>
                </div>
              </form>
            </div>
          </div>
</section>
