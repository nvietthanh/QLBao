<template>
  <div class="paginate">
    <el-pagination :current-page="currentPage || 1" :page-size="Number(paginate.per_page)" :background="paginateBackground"
      :pager-count="5" layout="prev, pager, next" :total="paginate.total"
      @current-change="handleCurrentChange" />
  </div>
</template>

<script>
export default {
  name: 'UiPaginate',
  emits: ['page-change'],
  props: {
    paginate: { type: Object, default: () => { } },
    currentPage: { type: Number, default: 1 },
    paginateBackground: { type: Boolean, default: false },
  },
  methods: {
    handleCurrentChange(value) {
      this.$emit('page-change', value)
    },

  }

}
</script>

<!-- <style>
.paginate .el-pagination {
  border: 1px solid;
  border-radius: 50px;
  overflow: hidden;
  height: 36px;
}
.paginate .btn-prev.is-first{
  border-right: 1px solid black
}
.paginate .btn-next.is-last{
  border-left: 1px solid black
}
.paginate ul.el-pager li{
  border-right: 1px solid black
}
.paginate ul.el-pager li:last-child{
  border-right: unset
}
.paginate ul li.is-active{
  background: #007bff !important;
  color: white;
}
.paginate .el-pagination.is-background .btn-next, .el-pagination.is-background .btn-prev, .el-pagination.is-background .el-pager li {
    margin: 0 ;
    background-color: white;
    border-radius: 0;
    height: 36px;
}
</style> -->
