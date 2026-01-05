<div class="modal fade" id="deleteBorrowModal-{{ $request->id }}" tabindex="-1">
    <div class="modal-dialog modal-sm modal-dialog-centered">
        <div class="modal-content bg-dark border-danger">

            <div class="modal-header">
                <h5 class="modal-title text-danger">Hapus Request?</h5>
                <button class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>

                        <div class="modal-body">
                <p class="mb-0">
                    Data peminjaman ini akan dihapus secara permanen.
                </p>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Batal</button>

                <form method="POST" action="{{ route('borrow-requests.destroy', $request->id) }}">
                    @csrf
                    @method('DELETE')
                    <button class="btn btn-danger">Hapus</button>
                </form>
            </div>

        </div>
    </div>
</div>
