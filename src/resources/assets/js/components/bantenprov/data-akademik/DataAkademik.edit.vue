<template>
  <div class="card">
    <div class="card-header">
      <i class="fa fa-table" aria-hidden="true"></i> Edit Data Akademik

      <ul class="nav nav-pills card-header-pills pull-right">
        <li class="nav-item">
          <button class="btn btn-primary btn-sm" role="button" @click="back">
            <i class="fa fa-arrow-left" aria-hidden="true"></i>
          </button>
        </li>
      </ul>
    </div>

    <div class="card-body">
       <vue-form class="form-horizontal form-validation" :state="state" @submit.prevent="onSubmit">

        <validate tag="div">
          <div class="form-group">
            <label for="nomor_un">Nomor UN</label>
            <input type="text" class="form-control" id="nomor_un" v-model="model.nomor_un" name="nomor_un" placeholder="Nomor UN" required autofocus>
            <field-messages name="nomor_un" show="$invalid && $submitted" class="text-danger">
              <small class="form-text text-success">Looks good!</small>
              <small class="form-text text-danger" slot="required">This field is a required field</small>
            </field-messages>
          </div>
        </validate>

        <validate tag="div">
          <div class="form-group">
            <label for="nama_siswa">Nama Siswa</label>
            <input type="text" class="form-control" id="nama_siswa" v-model="model.nama_siswa" name="nama_siswa" placeholder="Nama Siswa" required>
            <field-messages name="nama_siswa" show="$invalid && $submitted" class="text-danger">
              <small class="form-text text-success">Looks good!</small>
              <small class="form-text text-danger" slot="required">This field is a required field</small>
            </field-messages>
          </div>
        </validate>

        <!-- <validate tag="div">
          <div class="form-group">
            <label for="nomor_kk">Nomor KK</label>
            <input type="text" class="form-control" id="nomor_kk" v-model="model.nomor_kk" name="nomor_kk" placeholder="Nomor KK" required>
            <field-messages name="nomor_kk" show="$invalid && $submitted" class="text-danger">
              <small class="form-text text-success">Looks good!</small>
              <small class="form-text text-danger" slot="required">This field is a required field</small>
            </field-messages>
          </div>
        </validate> -->

        <validate tag="div">
          <div class="form-group">
            <label for="nomor_kk">Nomor KK </label>
            <input type="text" class="form-control" id="nomor_kk" v-model="model.nomor_kk" name="nomor_kk" placeholder="Nomor KK" >
              <!-- <field-messages name="nomor_kk" show="$invalid && $submitted" class="text-danger">
              <small class="form-text text-success">Looks good!</small>
              <small class="form-text text-danger" slot="required">This field is a required field</small>
                          </field-messages>  -->
          </div>
        </validate>

        <div class="form-row mt-4">
          <div class="col-md">
            <validate tag="div">
              <label for="tanggal_lahir">Tanggal Lahir</label>
              <input type="text" class="form-control" name="tanggal_lahir" v-model="model.tanggal_lahir" placeholder="Tanggal Lahir" required>

              <field-messages name="tanggal_lahir" show="$invalid && $submitted" class="text-danger">
                <small class="form-text text-success">Looks good!</small>
                <small class="form-text text-danger" slot="required">this field required field</small>
              </field-messages>
            </validate>
          </div>
        </div>

        <validate tag="div">
          <div class="form-group">
            <label for="bahasa_indonesia">Nilai Bahasa Indonesia</label>
            <input type="number" class="form-control" id="bahasa_indonesia" v-model="model.bahasa_indonesia" name="bahasa_indonesia" placeholder="Nilai Bahasa Indonesia" required>
            <field-messages name="bahasa_indonesia" show="$invalid && $submitted" class="text-danger">
              <small class="form-text text-success">Looks good!</small>
              <small class="form-text text-danger" slot="required">This field is a required field</small>
            </field-messages>
          </div>
        </validate>

        <validate tag="div">
          <div class="form-group">
            <label for="bahasa_inggris">Nilai Bahasa Inggris</label>
            <input type="number" class="form-control" id="bahasa_inggris" v-model="model.bahasa_inggris" name="bahasa_inggris" placeholder="Nilai Bahasa Inggris" required>
            <field-messages name="bahasa_inggris" show="$invalid && $submitted" class="text-danger">
              <small class="form-text text-success">Looks good!</small>
              <small class="form-text text-danger" slot="required">This field is a required field</small>
            </field-messages>
          </div>
        </validate>

        <validate tag="div">
          <div class="form-group">
            <label for="matematika">Nilai Matematika</label>
            <input type="number" class="form-control" id="matematika" v-model="model.matematika" name="matematika" placeholder="Nilai Matematika" required>
            <field-messages name="matematika" show="$invalid && $submitted" class="text-danger">
              <small class="form-text text-success">Looks good!</small>
              <small class="form-text text-danger" slot="required">This field is a required field</small>
            </field-messages>
          </div>
        </validate>

        <validate tag="div">
          <div class="form-group">
            <label for="ipa">Nilai IPA</label>
            <input type="number" class="form-control" id="ipa" v-model="model.ipa" name="ipa" placeholder="Nilai IPA" required>
            <field-messages name="ipa" show="$invalid && $submitted" class="text-danger">
              <small class="form-text text-success">Looks good!</small>
              <small class="form-text text-danger" slot="required">This field is a required field</small>
            </field-messages>
          </div>
        </validate>

        <div class="form-row mt-4">
          <div class="col-md">
            <validate tag="div">
            <label for="user_id">Username</label>
            <v-select name="user_id" v-model="model.user" :options="user" class="mb-4"></v-select>

            <field-messages name="user_id" show="$invalid && $submitted" class="text-danger">
              <small class="form-text text-success">Looks good!</small>
              <small class="form-text text-danger" slot="required">Username is a required field</small>
            </field-messages>
            </validate>
          </div>
        </div>

        <div class="form-group">
          <button type="submit" class="btn btn-primary">Submit</button>
          <button type="reset" class="btn btn-secondary" @click="reset">Reset</button>
        </div>

      </vue-form>
    </div>
  </div>
</template>

<script>
import swal from 'sweetalert2';
export default {
  mounted() {
    axios.get('api/data-akademik/' + this.$route.params.id + '/edit')
      .then(response => {
        if (response.data.status == true) {

          this.model.user             = response.data.data_akademik.user;
          this.model.old_nomor_un     = response.data.data_akademik.nomor_un;
          this.model.nomor_un         = response.data.data_akademik.nomor_un;
          this.model.nomor_kk         = response.data.data_akademik.nomor_kk;
          this.model.tanggal_lahir    = response.data.data_akademik.tanggal_lahir;
          this.model.nama_siswa       = response.data.data_akademik.nama_siswa;
          this.model.bahasa_indonesia = response.data.data_akademik.bahasa_indonesia;
          this.model.bahasa_inggris   = response.data.data_akademik.bahasa_inggris;
          this.model.matematika       = response.data.data_akademik.matematika;
          this.model.ipa              = response.data.data_akademik.ipa;


        } else {
          alert('Failed');
        }
      })
      .catch(function(response) {
        swal(
          'Not Found',
          'Oops... Your page is not found.',
          'error'
        );
        window.location.href = '#/admin/data-akademik';
      });

      axios.get('api/data-akademik/create')
      .then(response => {
        if (response.data.status == true && response.data.error == false) {
          this.model.user     = response.data.current_user;

          if(response.data.user_special == true){
            this.user = response.data.user;
          }else{
            this.user.push(response.data.user);
          }
        } else {
          swal(
            'Failed',
            'Oops... '+response.data.message,
            'error'
          );

          app.back();
        }
      })
      .catch(function(response) {
        swal(
          'Not Found',
          'Oops... Your page is not found.',
          'error'
        );

        app.back();
      });
  },
  data() {
    return {
      state: {},
      model: {
        old_nomor_un      : '',
        nomor_un          : '',
        nomor_kk          : '',
        tanggal_lahir     : '',
        nama_siswa        : '',
        bahasa_indonesia  : '',
        bahasa_inggris    : '',
        matematika        : '',
        ipa               : '',
        user              : '',
      },
      user: []
    }
  },
  methods: {
    onSubmit: function() {
      let app = this;

      if (this.state.$invalid) {
        return;
      } else {
        axios.put('api/data-akademik/' + this.$route.params.id, {
            user_id          : this.model.user.id,
            nomor_un         : this.model.nomor_un,
            nomor_kk         : this.model.nomor_kk,
            tanggal_lahir    : this.model.tanggal_lahir,
            old_nomor_un     : this.model.old_nomor_un,
            nama_siswa       : this.model.nama_siswa,
            bahasa_indonesia : this.model.bahasa_indonesia,
            bahasa_inggris   : this.model.bahasa_inggris,
            matematika       : this.model.matematika,
            ipa              : this.model.ipa,
          })
          .then(response => {
            let msg = response.data.message;

            if (response.data.status == true) {
              if(response.data.error == false){
                swal(
                  'Updated',
                  'Yeah!!! Your data has been updated.',
                  'success'
                );

                app.back();
              }else{
                swal(
                  'Failed',
                  `Oops... ${msg}`,
                  'error'
                );
              }
            } else {
              swal(
                'Failed',
                'Oops... '+ msg,
                'error'
              );

              app.back();
            }
          })
          .catch(function(response) {
            swal(
              'Not Found',
              'Oops... Your page is not found.',
              'error'
            );

            app.back();
          });
      }
    },
    reset() {
      axios.get('api/data-akademik/' + this.$route.params.id + '/edit')
        .then(response => {
          if (response.data.status == true) {
            this.model.user             = response.data.data_akademik.user.name;
            this.model.old_nomor_un     = response.data.data_akademik.nomor_un;
            this.model.nomor_un         = response.data.data_akademik.nomor_un;
            this.model.tanggal_lahir    = response.data.data_akademik.tanggal_lahir;
            this.model.nomor_kk         = response.data.data_akademik.nomor_kk;
            this.model.nama_siswa       = response.data.data_akademik.nama_siswa;
            this.model.bahasa_indonesia = response.data.data_akademik.bahasa_indonesia;
            this.model.bahasa_inggris   = response.data.data_akademik.bahasa_inggris;
            this.model.matematika       = response.data.data_akademik.matematika;
            this.model.ipa              = response.data.data_akademik.ipa;
          } else {
            alert('Failed');
          }
        })
        .catch(function(response) {
          alert('Break ');
        });
    },
    back() {
      window.location = '#/admin/data-akademik';
    }
  }
}
</script>
