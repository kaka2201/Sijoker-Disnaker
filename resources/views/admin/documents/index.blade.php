@extends('layouts.adminapp')

@section('title', 'Daftar Pengaduan')

@section('content')
<div class="container-fluid px-4 py-5">
    <div class="card shadow-lg border-0 rounded-lg">
        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
            <h4 class="mb-0"><i class="fas fa-comments"></i> Daftar Pengaduan</h4>
        </div>
        
        <div class="card-body">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            <div class="table-responsive">
                <table class="table table-hover align-middle table-bordered">
                    <thead class="table-primary text-center">
                        <tr>
                            <th>#</th>
                            <th>Nama</th>
                            <th>KTP</th>
                            <th>KK</th>
                            <th>Ijazah</th>
                            <th>AK1</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($documents as $document)
                            <tr class="text-center">
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $document->user->name }}</td>
                                @foreach (['ktp', 'kk', 'ijazah', 'ak1'] as $doc)
                                <td>
                                    <div class="d-flex">
                                        @if ($document->$doc)
                                            <a href="{{ route('admin.documents.show', [$document->{$doc . '_filename'}, $doc]) }}" target="_blank" class="btn mx-2 text-white btn-info btn-sm">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                        @endif
                                        
                                        <select name="{{ $doc }}_status" class="form-select form-select-sm update-status" 
                                            data-document-id="{{ $document->id }}" data-field="{{ $doc }}_status">
                                            <option value="pending" {{ $document->{$doc . '_status'} == 'pending' ? 'selected' : '' }}>Pending</option>
                                            <option value="confirmed" {{ $document->{$doc . '_status'} == 'confirmed' ? 'selected' : '' }}>Confirmed</option>
                                            <option value="rejected" {{ $document->{$doc . '_status'} == 'rejected' ? 'selected' : '' }}>Rejected</option>
                                        </select>
                                    </div>
                                </td>
                                @endforeach
                                <td>
                                    <button class="btn btn-warning text-white btn-message" 
                                        data-bs-toggle="modal" 
                                        data-bs-target="#messageModal" 
                                        data-id="{{ $document->user->id }}"
                                        data-message="{{ $document->user->revisi->revisi_message }}">
                                        <i class="fas fa-message"></i>
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center text-muted">Tidak ada dokumen ditemukan</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
                {{ $documents->links() }}
            </div>
        </div>
    </div>
</div>
<!-- Modal message -->
<div class="modal fade" id="messageModal" tabindex="-1" aria-labelledby="messageModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="messageModalLabel">Documents Messages</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="messageForm" action="" method="POST">
                @csrf
                @method('PATCH')
                <input type="hidden" name="document_id" id="document_id">
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="messages" class="form-label">Your Message</label>
                        <textarea name="messages" id="messages" class="form-control" rows="4" required></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Send Message</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener("DOMContentLoaded", function () {
        document.querySelectorAll('.update-status').forEach(function(selectElement) {
            selectElement.addEventListener('change', function() {
                let documentId = this.dataset.documentId;
                let field = this.dataset.field;
                let status = this.value;
    
                fetch(`/admin/documents/${documentId}/update-status`, {
                    method: 'PATCH',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({
                        field: field,
                        status: status
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        console.log('Status berhasil diperbarui');
                    } else {
                        alert('Gagal memperbarui status');
                    }
                })
                .catch(error => console.error('Error:', error));
            });
        });
    });

    document.addEventListener("DOMContentLoaded", function () {
        document.querySelectorAll('.btn-message').forEach(button => {
            button.addEventListener('click', function () {
                let documentId = this.dataset.id;
                let message = this.dataset.message || ''; // Jika tidak ada message, defaultnya kosong
                let form = document.getElementById('messageForm');
                let inputDocumentId = document.getElementById('document_id');
                let messageInput = document.getElementById('messages');

                // Set form action sesuai dengan ID dokumen
                form.action = `/admin/documents/${documentId}/message`; 

                // Set ID dokumen di input hidden
                inputDocumentId.value = documentId;

                // Isi textarea dengan message yang ada (jika ada)
                messageInput.value = message;
            });
        });
    });
</script>    
@endpush