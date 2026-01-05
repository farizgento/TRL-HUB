                        <!-- {{-- ================= MODAL DELETE ================= --}} -->
                        <div class="modal fade" id="deleteToolModal-{{ $tool->id }}" tabindex="-1">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">

                                    <div class="modal-header">
                                        <h5 class="modal-title">Hapus Alat</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>

                                    <div class="modal-body">
                                        <p>Yakin ingin menghapus alat berikut?</p>

                                        <ul class="list-unstyled">
                                            <li><strong>{{ $tool->asset_no }}</strong></li>
                                            <li>{{ $tool->tool_name }}</li>
                                        </ul>

                                        <p class="text-danger mb-0">Tindakan ini tidak bisa dibatalkan.</p>
                                    </div>

                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>

                                        <form action="{{ route('tools.destroy', $tool) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-danger" type="submit">Hapus</button>
                                        </form>
                                    </div>

                                </div>
                            </div>
                        </div>