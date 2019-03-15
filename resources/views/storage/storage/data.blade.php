@extends('storage.father.static')
@section('content')
<div class="layui-fluid">
  <div class="layui-card">
    <!-- 搜索控件 -->
  <div class="layui-form layui-card-header layuiadmin-card-header-auto">
          <div class="layui-form-item">
              <div class="layui-inline">
                  <div class="layui-form-item">
                      <div class="layui-inline">
                          <label class="layui-form-label">建仓日期：</label>
                          <div class="layui-input-inline">
                              <input type="text" class="layui-input" id="test-laydate-start"
                                     placeholder="日期范围">
                          </div>
                           <label class="layui-form-label">出库时间：</label>
                          <div class="layui-input-inline">
                              <input type="text" class="layui-input" id="test-laydate-out"
                                     placeholder="日期范围">
                          </div>
                         <!--  <div class="layui-form-mid">
                              -
                          </div>
                          <div class="layui-input-inline">
                              <input type="text" class="layui-input" id="test-laydate-end"
                                     placeholder="结束日期">
                          </div> -->
                      </div>
                      <!-- <span style="color: red">时间不选择默认为近10天</span> -->
                  </div>
              </div>
              <div class="layui-inline">
                  <label class="layui-form-label">仓库分类</label>
                  <div class="layui-input-block">
                      <select name="storage_type" id="storage_type" lay-verify="required">
                          <option value="#">所有</option>
                          <option value="1">国内仓</option>
                          <option value="0">海外仓</option>
                      </select>
                  </div>
              </div>
              <div class="layui-inline test-table-reload-btn">
                  <label>从当前数据中检索:</label>
                  <div class="layui-inline">
                      <input class="layui-input" name="id" id="test-table-demoReload" autocomplete="off">
                  </div>
                  <button class="layui-btn" data-type="reload">搜索</button>
                  <button class="layui-btn" id="outstorage">仓库信息导出</button>
              </div>
          </div>
  </div>
  <!-- 表格元素 -->
    <div class="layui-card-body">
      <table id="storagelist" lay-filter='button-listen'></table>
    </div>

  </div>
</div>
@endsection
@section('js')
@endsection