@php
$configData = Helper::appClasses();
@endphp

@extends('layouts/layoutMaster')

@section('title', 'Home')

@section('content')
<div class="row">
  <div class="card border-radius-md">
      <div class="card-body">
        <div class="row justify-content-between">

          <div class="col-md-12">
            <h4>Frequently Asked Questions</h4>
          </div>

          <div class="col-md-12">
            <a href="#" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addFaqModal">
              <span class="mdi mdi-plus-thick"></span><span class="mx-2"></span>
              Tambah FAQ
            </a>
          </div>

          <div class="modal fade" id="addFaqModal">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">

                    <div class="modal-header">
                        <h5 class="modal-title"><strong>Tambah Data <i>Frequently Asked Question</i></strong></h5>
                    </div>

                    <div class="modal-body">
                        <form action="{{ route('faq.store')}}" method="POST">
                            @csrf
                            <div class="form-group col-md-12 mb-3">
                                <label class="col-12 mb-2">Pertanyaan</label>
                                <div class="col-sm-12">
                                    <input type="text" name="question" class="form-control form-control-normal" placeholder="Pertanyaan" required>
                                </div>
                            </div>

                            <div class="form-group col-md-12 mb-3">
                                <label class="col-12 mb-2">Jawaban</label>
                                <div class="col-sm-12">
                                    <textarea name="answer" class="form-control form-control-normal" placeholder="Jawaban" required></textarea>
                                </div>
                            </div>

                            <div class="form-group col-md-12 mb-3">
                                <div class="col-sm-12">
                                    <button type="submit" class="btn btn-primary"><i class="far fa-save" style="margin-right: 8px;"></i> Simpan</button>
                                </div>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
          </div>

          <div class="table-responsive">
            <table class="datatables-users table mt-3">
              <thead class="table-light">
                <tr>
                  <th>No</th>
                  <th>Pertanyaan</th>
                  <th>Jawaban</th>
                  <th>Aksi</th>
                </tr>
              </thead>
              <tbody>
                @php
                    $no = 1;
                @endphp
                @foreach ($all_faqs as $faq)
                  <tr>
                    <td>{{ $no++ }}</td>
                    <td>{{ $faq->question }}</td>
                    <td>{{ $faq->answer }}</td>
                    <td>
                      <a href="#" data-bs-toggle="modal" data-bs-target="#editFaqModal{{ $faq->id }}" class="btn btn-sm btn-info m-1">
                        <span class="mdi mdi-pencil"></span>
                      </a>
                      <a href="#" data-bs-toggle="modal" data-bs-target="#deleteFaqModal{{ $faq->id }}" class="btn btn-sm btn-danger m-1">
                        <span class="mdi mdi-trash-can-outline"></span>
                      </a>

                      <div class="modal fade" id="editFaqModal{{ $faq->id }}">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">

                                <div class="modal-header">
                                    <h5 class="modal-title"><strong>Edit Data <i>Frequently Asked Question</i></strong></h5>
                                </div>

                                <div class="modal-body">
                                    <form action="{{ route('faq.update', $faq->id) }}" method="POST">
                                        @csrf
                                        @method('PUT')

                                        <div class="form-group col-md-12 mb-3">
                                            <label class="col-12 mb-2">Pertanyaan</label>
                                            <div class="col-sm-12">
                                                <input type="text" value="{{ $faq->question }}" name="question" class="form-control form-control-normal" placeholder="Pertanyaan" required>
                                            </div>
                                        </div>

                                        <div class="form-group col-md-12 mb-3">
                                            <label class="col-12 mb-2">Jawaban</label>
                                            <div class="col-sm-12">
                                                <textarea name="answer" class="form-control form-control-normal" placeholder="Jawaban" required>{{ $faq->answer }}</textarea>
                                            </div>
                                        </div>

                                        <div class="form-group col-md-12 mb-3">
                                            <div class="col-sm-12">
                                                <button type="submit" class="btn btn-primary"><i class="far fa-save" style="margin-right: 8px;"></i> Simpan Perubahan</button>
                                            </div>
                                        </div>

                                    </form>
                                </div>
                            </div>
                        </div>
                      </div>

                      <div class="modal fade" id="deleteFaqModal{{ $faq->id }}">
                          <div class="modal-dialog modal-dialog-centered">
                              <div class="modal-content">

                                  <div class="modal-header">
                                      <h5 class="modal-title"><strong>Hapus Data <i>Frequently Asked Question</i></strong></h5>
                                  </div>

                                  <div class="modal-body">
                                      <form action="{{ route('faq.destroy', $faq->id) }}" method="POST">
                                          @csrf
                                          @method('DELETE')

                                          <div class="col text-center">
                                              <p>Tekan <strong>Hapus</strong> untuk menghapus data FAQ <i>'{{ $faq->question }}'</i></p>

                                              <button class="btn btn-danger btn-sm" type="submit">Hapus</button>
                                              <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Batal</button>
                                          </div>
                                      </form>
                                  </div>
                              </div>
                          </div>
                      </div>

                    </td>
                  </tr>
                @endforeach

              </tbody>
            </table>
          </div>

        </div>
      </div>
  </div>
</div>

<br><p>For more layout options refer <a href="{{ config('variables.documentation') ? config('variables.documentation').'/laravel-introduction.html' : '#' }}" target="_blank" rel="noopener noreferrer">documentation</a>.</p>
@endsection
