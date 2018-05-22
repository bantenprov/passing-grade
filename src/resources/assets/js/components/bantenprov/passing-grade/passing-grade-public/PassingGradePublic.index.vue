<template>
  <div class="card">
    <div class="card-header">
      <i class="fa fa-table" aria-hidden="true"></i> {{ title }}

      <ul class="nav nav-pills card-header-pills pull-right">
        <li class="nav-item">
          <!-- <button class="btn btn-primary btn-sm" role="button" @click="createRow">
            <i class="fa fa-plus" aria-hidden="true"></i>
          </button> -->
        </li>
      </ul>
    </div>

    <div class="card-body">
      <div class="d-flex justify-content-between align-items-center">
        <vuetable-filter-bar></vuetable-filter-bar>
      </div>

      <div style="margin:20px 0;">
        <div v-if="loading" class="d-flex justify-content-start align-items-center">
          <i class="fa fa-refresh fa-spin fa-fw"></i>
          <span>Loading...</span>
        </div>
      </div>

      <div class="table-responsive">
        <vuetable ref="vuetable"
          :api-url="api_url"
          :fields="fields"
          :sort-order="sortOrder"
          :css="css.table"
          pagination-path=""
          :per-page="10"
          :append-params="moreParams"
          @vuetable:pagination-data="onPaginationData"
          @vuetable:loading="onLoading"
          @vuetable:loaded="onLoaded">
          <template slot="actions" slot-scope="props">
            <div class="btn-group pull-right" role="group" style="display:flex;">
              <!-- <button class="btn btn-info btn-sm" role="button" @click="viewRow(props.rowData)">
                <span class="fa fa-eye"></span>
              </button> -->
              <button class="btn btn-info btn-sm" role="button" @click="viewRowGeneral(props.rowData)">
                <span class="fa fa-eye"></span> Umum
              </button>
              <button class="btn btn-info btn-sm" role="button" @click="viewRowAchievement(props.rowData)">
                <span class="fa fa-eye"></span> Prestasi
              </button>
              <!-- <button class="btn btn-warning btn-sm" role="button" @click="editRow(props.rowData)">
                <span class="fa fa-pencil"></span>
              </button> -->
              <!-- <button class="btn btn-danger btn-sm" role="button" @click="deleteRow(props.rowData)">
                <span class="fa fa-trash"></span>
              </button> -->
            </div>
          </template>
        </vuetable>
      </div>

      <div class="d-flex justify-content-between align-items-center">
        <vuetable-pagination-info ref="paginationInfo"></vuetable-pagination-info>
        <vuetable-pagination ref="pagination"
          :css="css.pagination"
          @vuetable-pagination:change-page="onChangePage">
        </vuetable-pagination>
      </div>
    </div>
  </div>
</template>

<style>
.vuetable-th-sequence{
  width: 1px;
}
.vuetable-th-slot-actions {
  width: 1px;
  white-space: normal;
}
</style>

<script>
import swal from 'sweetalert2';
import VuetablePaginationInfo from 'vuetable-2/src/components/VuetablePaginationInfo';

export default {
  components: {
    VuetablePaginationInfo,
  },
  data() {
    return {
      loading: true,
      title: 'Passing Grade',
      api_url: '/api/passing-grade-public',
      fields: [
        {
          name: '__sequence',
          title: '#',
          titleClass: 'center aligned',
          dataClass: 'right aligned',
        },
        {
          name: 'nama',
          title: 'Nama Sekolah',
          sortField: 'nama',
          titleClass: 'center aligned',
        },
        {
          name: 'jalur_umum',
          title: 'Jalur Umum',
          // sortField: 'jalur_umum',
          titleClass: 'center aligned',
        },
        {
          name: 'jalur_prestasi',
          title: 'Jalur Prestasi',
          // sortField: 'jalur_prestasi',
          titleClass: 'center aligned',
        },
        {
          name: 'jumlah_pendaftar',
          title: 'Jumlah Pendaftar',
          // sortField: 'jumlah_pendaftar',
          titleClass: 'center aligned',
        },
        {
          name: '__slot:actions',
          title: 'Actions',
          titleClass: 'center aligned',
          dataClass: 'center aligned',
        },
      ],
      sortOrder: [
        {
          field: 'npsn',
          direction: 'asc',
        },
      ],
      moreParams: {
        //
      },
      css: {
        table: {
          tableClass: 'table table-hover',
          ascendingIcon: 'fa fa-chevron-up',
          descendingIcon: 'fa fa-chevron-down',
        },
        pagination: {
          wrapperClass: 'vuetable-pagination btn-group',
          activeClass: 'active',
          disabledClass: 'disabled',
          pageClass: 'btn btn-light',
          linkClass: 'btn btn-light',
          icons: {
            first: 'fa fa-angle-double-left',
            prev: 'fa fa-angle-left',
            next: 'fa fa-angle-right',
            last: 'fa fa-angle-double-right',
          },
        },
      },
    }
  },
  methods: {
    onPaginationData(paginationData) {
      this.$refs.pagination.setPaginationData(paginationData);
      this.$refs.paginationInfo.setPaginationData(paginationData);
    },
    onChangePage(page) {
      this.$refs.vuetable.changePage(page);
    },
    onLoading: function() {
      this.loading = true;
    },
    onLoaded: function() {
      this.loading = false;
    },
    createRow() {
      window.location = '#/passing-grade-public/create';
    },
    viewRow(rowData) {
      window.location = '#/passing-grade-public/'+rowData.id;
    },
    viewRowGeneral(rowData) {
      window.location = '#/passing-grade-public/'+rowData.id+'/umum';
    },
    viewRowAchievement(rowData) {
      window.location = '#/passing-grade-public/'+rowData.id+'/prestasi';
    },
    editRow(rowData) {
      window.location = '#/passing-grade-public/'+rowData.id+'/edit';
    },
    deleteRow(rowData) {
      let app = this;

      swal({
        title: 'Are you sure?',
        text: 'You won\'t be able to revert this!',
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it!',
        cancelButtonText: 'No, cancel!',
        confirmButtonClass: 'btn btn-success',
        cancelButtonClass: 'btn btn-danger',
        buttonsStyling: false,
        reverseButtons: true,
      }).then((result) => {
        if (result.value) {
          axios.delete('/api/passing-grade-public/'+rowData.id)
            .then(function(response) {
              if (response.data.status == true && response.data.error == false) {
                app.$refs.vuetable.reload();

                swal(
                  'Deleted',
                  'Yeah!!! Your data has been deleted.',
                  'success',
                );
              } else {
                swal(
                  'Failed',
                  'Oops... '+response.data.message,
                  'error',
                );
              }
            })
            .catch(function(response) {
              swal(
                'Not Found',
                'Oops... Your page is not found.',
                'error',
              );
            });
        } else if (result.dismiss === swal.DismissReason.cancel) {
          swal(
            'Cancelled',
            'Your data is safe.',
            'error',
          );
        }
      });
    },
  },
  events: {
    'filter-set' (filterText) {
      this.moreParams = {
        filter: filterText,
      };

      Vue.nextTick(() => this.$refs.vuetable.refresh());
    },
    'filter-reset'() {
      this.moreParams = {
        //
      };

      Vue.nextTick(() => this.$refs.vuetable.refresh());
    },
  },
}
</script>
