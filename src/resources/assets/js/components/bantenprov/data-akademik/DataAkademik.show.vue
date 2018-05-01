<template>
  <div class="card">
    <div class="card-header">
      <i class="fa fa-table" aria-hidden="true"></i> Data Akademik {{ model.label }}

      <ul class="nav nav-pills card-header-pills pull-right">
        <li class="nav-item">
          <!-- <button class="btn btn-success btn-sm" role="button" @click="show">
            <span class="fa fa-pencil"></span> EDIT
          </button> -->
          <button class="btn btn-primary btn-sm" role="button" @click="back">
            <i class="fa fa-arrow-left" aria-hidden="true"></i>
          </button>
        </li>
      </ul>
    </div>

    <div class="card-body">
      <dl class="row">
        <dt class="col-4">Nomor UN</dt>
        <dd class="col-8">{{ model.nomor_un }}</dd>

        <dt class="col-4">Nomor KK</dt>
        <dd class="col-8">{{ model.nomor_kk }}</dd>

        <dt class="col-4">NISN</dt>
        <dd class="col-8">{{ model.nisn }}</dd>

        <dt class="col-4">Nama Siswa</dt>
        <dd class="col-8">{{ model.nama_siswa }}</dd>

        <dt class="col-4">Nilai Bahasa Indonesia</dt>
        <dd class="col-8">{{ model.bahasa_indonesia }}</dd>

        <dt class="col-4">Nilai Bahasa Inggris</dt>
        <dd class="col-8">{{ model.bahasa_inggris }}</dd>

        <dt class="col-4">Nilai Metematika</dt>
        <dd class="col-8">{{ model.matematika }}</dd>

        <dt class="col-4">Nilai IPA</dt>
        <dd class="col-8">{{ model.ipa }}</dd>

        <dt class="col-4">Tempat Lahir</dt>
        <dd class="col-8">{{ model.tempat_lahir }}</dd>

        <dt class="col-4">Tanggal Lahir</dt>
        <dd class="col-8">{{ model.tanggal_lahir }}</dd>

        <dt class="col-4">Jenis Kelamin</dt>
        <dd class="col-8">{{ model.jenis_kelamin }}</dd>

        <dt class="col-4">Nama Orang Tua</dt>
        <dd class="col-8">{{ model.nama_ortu }}</dd>

        <dt class="col-4">Alamat</dt>
        <dd class="col-8">{{ model.alamat }}</dd>

        <dt class="col-4">NPSN Asal Sekolah</dt>
        <dd class="col-8">{{ model.npsn_asal_sekolah }}</dd>

        <dt class="col-4">Asal Sekolah</dt>
        <dd class="col-8">{{ model.asal_sekolah }}</dd>

      </dl>

    </div>
    <div class="card-footer text-muted">
        <div class="row">
          <div class="col-md">
            <b>Username :</b> {{ model.user.name }}
          </div>
          <div class="col-md">
            <div class="col-md text-right">Dibuat : {{ model.created_at }}</div>
            <div class="col-md text-right">Diperbaiki : {{ model.updated_at }}</div>
          </div>
        </div>
      </div>
  </div>
</template>

<script>
export default {
  mounted() {
    axios.get('api/data-akademik/' + this.$route.params.id)
      .then(response => {
        if (response.data.status == true) {
          this.model.user             = response.data.data_akademik.user;
          this.model.nomor_un         = response.data.data_akademik.nomor_un;
          this.model.nomor_kk         = response.data.data_akademik.nomor_kk;
          this.model.nisn             = response.data.data_akademik.nisn;
          this.model.nama_siswa       = response.data.data_akademik.nama_siswa;
          this.model.bahasa_indonesia = response.data.data_akademik.bahasa_indonesia;
          this.model.bahasa_inggris   = response.data.data_akademik.bahasa_inggris;
          this.model.matematika       = response.data.data_akademik.matematika;
          this.model.ipa              = response.data.data_akademik.ipa;
          this.model.tempat_lahir     = response.data.data_akademik.tempat_lahir;
          this.model.tanggal_lahir    = response.data.data_akademik.tanggal_lahir;
          this.model.jenis_kelamin    = response.data.data_akademik.jenis_kelamin;
          this.model.nama_ortu        = response.data.data_akademik.nama_ortu;
          this.model.alamat           = response.data.data_akademik.alamat;
          this.model.npsn_asal_sekolah = response.data.data_akademik.npsn_asal_sekolah;
          this.model.asal_sekolah         = response.data.data_akademik.asal_sekolah;
          this.model.created_at       = response.data.data_akademik.created_at;
          this.model.updated_at       = response.data.data_akademik.updated_at;

        }
        else {
          alert('Failed');
        }
      })
      .catch(function(response) {
        alert('Break');
        window.location.href = '#/admin/data-akademik';
      })

  },
  data() {
    return {
      state: {},
      model: {
        nomor_un          : '',
        nomor_kk          : '',
        nisn              : '',
        nama_siswa        : '',
        bahasa_indonesia  : '',
        bahasa_inggris    : '',
        matematika        : '',
        ipa               : '',
        tempat_lahir      : '',
        tanggal_lahir     : '',
        jenis_kelamin     : '',
        nama_ortu         : '',
        alamat            : '',
        npsn_asal_sekolah : '',
        asal_sekolah      : '',
        user              : '',
        created_at        : '',
        updated_at        : '',

      },
    }
  },
  methods: {
    show() {
      window.location = '#/admin/data-akademik/'+this.$route.params.id+'/edit';
    },
    back() {
      window.location = '#/admin/data-akademik';
    }
  }
}
</script>
