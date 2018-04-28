<template>
  <div class="card">
    <div class="card-header">
      <i class="fa fa-table" aria-hidden="true"></i> {{ title }}

      <div class="btn-group pull-right" role="group" style="display:flex;">
        <button class="btn btn-info btn-sm" role="button" @click="view">
          <i class="fa fa-eye" aria-hidden="true"></i>
        </button>
        <button class="btn btn-primary btn-sm" role="button" @click="back">
          <i class="fa fa-arrow-left" aria-hidden="true"></i>
        </button>
      </div>
    </div>

    <div class="card-body">
      <vue-form class="form-horizontal form-validation" :state="state" @submit.prevent="onSubmit">
        <div class="form-row mt-4">
          <div class="col-md">
            <validate tag="div">
              <label for="nama">Kriteria</label>
              <input type="text" class="form-control" name="nama" v-model="model.nama" placeholder="Kriteria" required autofocus>

              <field-messages name="nama" show="$invalid && $submitted" class="text-danger">
                <small class="form-text text-success">Looks good!</small>
                <small class="form-text text-danger" slot="required">Kriteria is a required field</small>
              </field-messages>
            </validate>
          </div>
        </div>

        <div class="form-row mt-4">
          <div class="col-md">
            <validate tag="div">
              <label for="instansi">Instansi</label>
              <input type="text" class="form-control" name="instansi" v-model="model.instansi" placeholder="Instansi" required>

              <field-messages name="instansi" show="$invalid && $submitted" class="text-danger">
                <small class="form-text text-success">Looks good!</small>
                <small class="form-text text-danger" slot="required">Instansi is a required field</small>
              </field-messages>
            </validate>
          </div>
        </div>

        <div class="form-row mt-4">
          <div class="col-md">
            <validate tag="div">
              <label for="nilai">Nilai</label>
              <input type="text" class="form-control" name="nilai" v-model="model.nilai" placeholder="Nilai" required>

              <field-messages name="nilai" show="$invalid && $submitted" class="text-danger">
                <small class="form-text text-success">Looks good!</small>
                <small class="form-text text-danger" slot="required">Nilai is a required field</small>
              </field-messages>
            </validate>
          </div>
        </div>

        <div class="form-row mt-4">
          <div class="col-md">
            <validate tag="div">
              <label for="user_id">Username</label>
              <v-select name="user_id" v-model="model.user" :options="user" placeholder="Username" required></v-select>

              <field-messages name="user_id" show="$invalid && $submitted" class="text-danger">
                <small class="form-text text-success">Looks good!</small>
                <small class="form-text text-danger" slot="required">User is a required field</small>
              </field-messages>
            </validate>
          </div>
        </div>

        <div class="form-row mt-4">
          <div class="col-md">
            <button type="submit" class="btn btn-primary">Update</button>
            <button type="reset" class="btn btn-secondary" @click="reset">Reset</button>
          </div>
        </div>

      </vue-form>
    </div>
  </div>
</template>

<script>
import swal from 'sweetalert2';

export default {
  data() {
    return {
      state: {},
      title: 'Edit Master SKTM',
      model: {
        nama        : '',
        instansi    : '',
        nilai       : '',
        user_id     : '',
        created_at  : '',
        updated_at  : '',

        user        : '',
      },
      user  : [],
    }
  },
  mounted(){
    let app = this;

    axios.get('api/master-sktm/'+this.$route.params.id+'/edit')
      .then(response => {
        if (response.data.status == true && response.data.error == false) {
          this.model.nama     = response.data.master_sktm.nama;
          this.model.instansi = response.data.master_sktm.instansi;
          this.model.nilai    = response.data.master_sktm.nilai;
          this.model.user_id  = response.data.master_sktm.user_id;

          if (response.data.master_sktm.user === null) {
            this.model.user = response.data.current_user;
          } else {
            this.model.user = response.data.master_sktm.user;
          }

          if(response.data.user_special == true){
            this.user = response.data.users;
          }else{
            this.user.push(response.data.users);
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
  methods: {
    onSubmit: function() {
      let app = this;

      if (this.state.$invalid) {
        return;
      } else {
        axios.put('api/master-sktm/'+this.$route.params.id, {
            nama      : this.model.nama,
            instansi  : this.model.instansi,
            nilai     : this.model.nilai,
            user_id   : this.model.user.id,
          })
          .then(response => {
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
                  'Oops... '+response.data.message,
                  'error'
                );
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
      }
    },
    reset() {
      this.model = {
        nama        : '',
        instansi    : '',
        nilai       : '',
        user_id     : '',
        created_at  : '',
        updated_at  : '',

        user        : '',
      };
    },
    view() {
      window.location = '#/admin/master-sktm/'+this.$route.params.id;
    },
    back() {
      window.location = '#/admin/master-sktm';
    }
  }
}
</script>
