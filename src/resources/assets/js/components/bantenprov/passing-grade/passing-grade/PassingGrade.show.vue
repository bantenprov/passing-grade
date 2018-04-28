<template>
  <div class="card">
    <div class="card-header">
      <i class="fa fa-table" aria-hidden="true"></i> {{ title }}

      <div class="btn-group pull-right" role="group" style="display:flex;">
        <button class="btn btn-warning btn-sm" role="button" @click="edit">
          <i class="fa fa-pencil" aria-hidden="true"></i>
        </button>
        <button class="btn btn-primary btn-sm" role="button" @click="back">
          <i class="fa fa-arrow-left" aria-hidden="true"></i>
        </button>
      </div>
    </div>

    <div class="card-body">
      <dl class="row">
          <dt class="col-4">Kriteria</dt>
          <dd class="col-8">{{ model.nama }}</dd>

          <dt class="col-4">Instansi</dt>
          <dd class="col-8">{{ model.instansi }}</dd>

          <dt class="col-4">Nilai</dt>
          <dd class="col-8">{{ model.nilai }}</dd>
      </dl>
    </div>

    <div class="card-footer text-muted">
      <div class="row">
        <div class="col-md">
          <b>Username :</b> {{ model.user.name }}
        </div>
        <div class="col-md">
          <div class="col-md text-right">Dibuat : {{ model.created_at }}</div>
          <div class="col-md text-right">Diperbarui : {{ model.updated_at }}</div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import swal from 'sweetalert2';

export default {
  data() {
    return {
      state: {},
      title: 'View Master SKTM',
      model: {
        nama        : '',
        instansi    : '',
        nilai       : '',
        user_id     : '',
        created_at  : '',
        updated_at  : '',

        user        : [],
      },
    }
  },
  mounted() {
    let app = this;

    axios.get('api/master-sktm/'+this.$route.params.id)
      .then(response => {
        if (response.data.status == true && response.data.error == false) {
          this.model.nama       = response.data.master_sktm.nama;
          this.model.instansi   = response.data.master_sktm.instansi;
          this.model.nilai      = response.data.master_sktm.nilai;
          this.model.user_id    = response.data.master_sktm.user_id;
          this.model.created_at = response.data.master_sktm.created_at;
          this.model.updated_at = response.data.master_sktm.updated_at;

          this.model.user       = response.data.master_sktm.user;

          if (this.model.user === null) {
            this.model.user = {
              'id'    : this.model.user_id,
              'name'  : ''
            };
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
    edit() {
      window.location = '#/admin/master-sktm/'+this.$route.params.id+'/edit';
    },
    back() {
      window.location = '#/admin/master-sktm';
    }
  }
}
</script>