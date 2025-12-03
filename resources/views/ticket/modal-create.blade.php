<!-- Create Ticket Modal -->
<div id="createTicketModal" 
     class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">

    <div class="bg-white w-full max-w-lg rounded-lg shadow-lg p-6">

        <h2 class="text-xl font-semibold mb-4 text-orange-500">
            Create New Ticket
        </h2>

        <form action="{{ route('ticket.store') }}" method="POST">
            @csrf

            <div class="mb-4">
                <label class="block font-medium mb-1">Title</label>
                <input type="text" name="title" required
                       class="w-full border border-gray-300 p-2 rounded-lg">
            </div>

            <div class="mb-4">
                <label class="block font-medium mb-1">Description</label>
                <textarea name="description" rows="3" required
                          class="w-full border border-gray-300 p-2 rounded-lg"></textarea>
            </div>

            <div class="flex justify-end gap-3 pt-4">
                <button type="button"
                        onclick="document.getElementById('createTicketModal').classList.add('hidden')"
                        class="px-4 py-2 bg-gray-300 rounded-lg">
                    Cancel
                </button>

                <button type="submit"
                        class="px-4 py-2 bg-orange-500 text-white rounded-lg">
                    Save Ticket
                </button>
            </div>

        </form>
    </div>
</div>
