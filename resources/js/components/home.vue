<template>

	<div>
        
        <div class="container-fluid">

          <!-- Page Heading -->
          <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
            <router-link :to="{ name: 'search-report' }" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fas fa-download fa-sm text-white-50"></i> Generate Report</router-link>
          </div>

          <!-- Content Row -->
          <div class="row">

            <!-- Earnings (Today) Card Example -->
            <div class="col-xl-3 col-md-6 mb-4">
              <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                  <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                      <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Earnings (Today)</div>
                      <div class="h5 mb-0 font-weight-bold text-gray-800"><b>৳</b>{{ todayEarning }}</div>
                    </div>
                    <div class="col-auto">
                      <i class="fas fa-calendar fa-2x text-gray-300"></i>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <!-- Sell (Today) Card Example -->
            <div class="col-xl-3 col-md-6 mb-4">
              <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                  <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                      <div class="text-xs font-weight-bold text-success text-uppercase mb-1">SELL (Today)</div>
                      <div class="h5 mb-0 font-weight-bold text-gray-800"><b>৳</b>{{ todaySell }}</div>
                    </div>
                    <div class="col-auto">
                      <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <!-- Due (Today) Card Example -->
            <div class="col-xl-3 col-md-6 mb-4">
              <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                  <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                      <div class="text-xs font-weight-bold text-info text-uppercase mb-1">DUE (Today)</div>
                      <div class="h5 mb-0 font-weight-bold text-gray-800"><b>৳</b>{{ todayDue }}</div>
                    </div>
                    <div class="col-auto">
                      <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <!-- Expense (Today) Card Example -->
            <div class="col-xl-3 col-md-6 mb-4">
              <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                  <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                      <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">EXPENSE (Today)</div>
                      <div class="h5 mb-0 font-weight-bold text-gray-800"><b>৳</b>{{ todayExpense }}</div>
                    </div>
                    <div class="col-auto">
                      <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                    </div>
                  </div>
                </div>
              </div>
            </div>


            <!-- Earnings (This Month) Card Example -->
            <div class="col-xl-3 col-md-6 mb-4">
              <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                  <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                      <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Earnings (This Month)</div>
                      <div class="h5 mb-0 font-weight-bold text-gray-800"><b>৳</b>{{ thisMonthEarning }}</div>
                    </div>
                    <div class="col-auto">
                      <i class="fas fa-calendar fa-2x text-gray-300"></i>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <!-- Sell (This Month) Card Example -->
            <div class="col-xl-3 col-md-6 mb-4">
              <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                  <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                      <div class="text-xs font-weight-bold text-success text-uppercase mb-1">SELL (This Month)</div>
                      <div class="h5 mb-0 font-weight-bold text-gray-800"><b>৳</b>{{ thisMonthSell }}</div>
                    </div>
                    <div class="col-auto">
                      <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <!-- Due (This Month) Card Example -->
            <div class="col-xl-3 col-md-6 mb-4">
              <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                  <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                      <div class="text-xs font-weight-bold text-info text-uppercase mb-1">DUE (This Month)</div>
                      <div class="h5 mb-0 font-weight-bold text-gray-800"><b>৳</b>{{ thisMonthDue }}</div>
                    </div>
                    <div class="col-auto">
                      <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <!-- Expense (This Month) Card Example -->
            <div class="col-xl-3 col-md-6 mb-4">
              <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                  <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                      <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">EXPENSE (This Month)</div>
                      <div class="h5 mb-0 font-weight-bold text-gray-800"><b>৳</b>{{ thisMonthExpense }}</div>
                    </div>
                    <div class="col-auto">
                      <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                    </div>
                  </div>
                </div>
              </div>
            </div>


            <!-- Earnings (All Time) Card Example -->
            <div class="col-xl-3 col-md-6 mb-4">
              <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                  <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                      <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Earnings (All Time)</div>
                      <div class="h5 mb-0 font-weight-bold text-gray-800"><b>৳</b>{{ allTimeEarning }}</div>
                    </div>
                    <div class="col-auto">
                      <i class="fas fa-calendar fa-2x text-gray-300"></i>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <!-- Sell (All Time) Card Example -->
            <div class="col-xl-3 col-md-6 mb-4">
              <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                  <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                      <div class="text-xs font-weight-bold text-success text-uppercase mb-1">SELL (All Time)</div>
                      <div class="h5 mb-0 font-weight-bold text-gray-800"><b>৳</b>{{ allTimeSell }}</div>
                    </div>
                    <div class="col-auto">
                      <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <!-- Due (All Time) Card Example -->
            <div class="col-xl-3 col-md-6 mb-4">
              <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                  <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                      <div class="text-xs font-weight-bold text-info text-uppercase mb-1">DUE (All Time)</div>
                      <div class="h5 mb-0 font-weight-bold text-gray-800"><b>৳</b>{{ allTimeDue }}</div>
                    </div>
                    <div class="col-auto">
                      <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <!-- Expense (All Time) Card Example -->
            <div class="col-xl-3 col-md-6 mb-4">
              <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                  <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                      <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">EXPENSE (All Time)</div>
                      <div class="h5 mb-0 font-weight-bold text-gray-800"><b>৳</b>{{ allTimeExpense }}</div>
                    </div>
                    <div class="col-auto">
                      <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                    </div>
                  </div>
                </div>
              </div>
            </div>


          </div>

            <!-- DataTales Example -->
          <div class="card shadow mb-4">
            <div class="card-header py-2">
              <span class="m-0 font-weight-bold text-primary">Stock Out Products </span>
            </div>
            <div class="card-body">
              <div class="table-responsive">
                <table class="table table-bordered" id="" width="100%" cellspacing="0">
                  <thead>
                    <tr class="text-center">
                      <th>Photo</th>
                      <th>Name</th>
                      <th>Code</th>
                      <th>Supplier</th>
                      <th>Category</th>
                      <th>Status</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tfoot>
                    <tr class="text-center">
                      <th>Photo</th>
                      <th>Name</th>
                      <th>Code</th>
                      <th>Supplier</th>
                      <th>Category</th>
                      <th>Status</th>
                      <th>Action</th>
                    </tr>
                  </tfoot>
                  <tbody v-if="stockOutProducts != '' ">
                    <tr v-for="product in stockOutProducts" :key="product.id" class="text-center">
                      <td>
                        <img :src="'/backend/uploads/product/' + product.photo" width="50px" :title=" 'Root: '+ product.root">
                      </td>
                      <td>{{product.name}}</td>
                      <td>{{product.code}}</td>
                      <td>{{product.supplier.name}}</td>
                      <td>{{product.category.name}}</td>
                      <td v-if="product.quantity > 0"><span class="badge badge-success">Availble</span></td>
                      <td v-else><span class="badge badge-danger">Stock Out</span></td>
                      <td>
                        <router-link :to="{ name: 'edit-stock', params:{id: product.id} }" style="padding-right:5px" title="Edit"><i class="fa fa-edit text-success"></i></router-link>
                      </td>
                    </tr>
                  </tbody>
                  <tbody v-else>
                    <tr>
                        <td colspan="7" class="text-center">
                            <br><h1>No data found!</h1><br>
                        </td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>
          </div>


        </div>
        <!-- /.container-fluid -->

    </div>

</template>

<script type="text/javascript">
  export default { 
    created(){
      if( !User.loggedIn() ){
        this.$router.push({ name: '/' })
      }else{
        this.todayData(),
        this.thisMonthData(),
        this.allTimeData(),
        this.stockOutProduct()
      }

    },

    data(){
          return{
              todaySell:'',
              todayExpense:'',
              todayDue:'',
              todayEarning:'',
              
              thisMonthSell:'',
              thisMonthExpense:'',
              thisMonthDue:'',
              thisMonthEarning:'',

              allTimeSell:'',
              allTimeExpense:'',
              allTimeDue:'',
              allTimeEarning:'',

              stockOutProducts:{},
          }
      },

    methods:{
        todayData(){
          axios.get('/api/today-data')
          .then( ({data}) => {
              this.todaySell = data[0], 
              this.todayEarning = data[1],
              this.todayDue = data[2],
              this.todayExpense = data[3]
          })
          .catch(error => {
              Toast.fire({
                icon: 'error',
                title: 'Something went wrong!'
              })

          })
        },
        thisMonthData(){
          axios.get('/api/this-month-data')
          .then( ({data}) => {
              this.thisMonthSell = data[0], 
              this.thisMonthEarning = data[1],
              this.thisMonthDue = data[2],
              this.thisMonthExpense = data[3]
          })
          .catch(error => {
              Toast.fire({
                icon: 'error',
                title: 'Something went wrong!'
              })

          })
        },
        allTimeData(){
          axios.get('/api/alltime-data')
          .then( ({data}) => {
              this.allTimeSell = data[0], 
              this.allTimeEarning = data[1],
              this.allTimeDue = data[2],
              this.allTimeExpense = data[3]
          })
          .catch(error => {
              Toast.fire({
                icon: 'error',
                title: 'Something went wrong!'
              })

          })
        },
        stockOutProduct(){
          axios.get('/api/stock-out')
          .then( ({data}) => {
              this.stockOutProducts = data
          })
          .catch(error => {
              Toast.fire({
                icon: 'error',
                title: 'Something went wrong!'
              })

          })
        },
        

    },

    

  }
</script>



<style type="text/css">
	
</style>