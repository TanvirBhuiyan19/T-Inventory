<template>

	<div>
     <!-- Begin Page Content -->
        <div class="container-fluid">

          <!-- Breadcrumbs-->
        <ol class="breadcrumb">
          <li class="breadcrumb-item">
            <router-link to="/home">Dashboard</router-link>
          </li>
          <li class="breadcrumb-item active">Today's Report</li>
        </ol>
          <!-- DataTales Example -->
          <div class="card shadow mb-4">
            <div class="card-header py-3">
              <span class="m-0 font-weight-bold text-primary">Today's Report List</span>
              <a :href=" '/api/today-report-pdf/'" target="_blank" v-if="todaySell != '' "  class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm" id="add_new"><i class="fas fa-download fa-sm text-white-50"></i> Generate PDF</a>
            </div>
            <div class="card-body">
                <h4 class="text-center" style="color: darkorange">Today Expenses</h4>
              <div class="table-responsive">
                <table class="table table-bordered" id="" width="100%" cellspacing="0">
                  <thead>
                    <tr class="text-center">
                      <th>Details</th>
                      <th>Amount</th>
                    </tr>
                  </thead>
                  <tbody v-if="todayExpenses != '' ">
                    <tr v-for="expense in todayExpenses" :key="expense.id" class="text-center">
                      <td>{{expense.details}}</td>
                      <td>{{expense.amount}}</td>
                    </tr>
                  </tbody>
                  <tbody v-else>
                    <tr>
                        <td colspan="2" class="text-center">
                            <br><h3>No Expense Found Today!</h3><br>
                        </td>
                    </tr>
                  </tbody>
                </table>
              </div>

                <div class="row">
                    <div class="col-md-6"></div>
                    <div class="col-md-6">
                        <table class="table table-bordered" id="" width="100%" cellspacing="0">
                            <tbody>
                                <tr>
                                    <td>Today Sell</td>
                                    <td>{{ todaySell }} Taka</td>
                                </tr>
                                <tr>
                                    <td>Today Profit</td>
                                    <td>{{ todayErnings }} Taka</td>
                                </tr>
                                <tr>
                                    <td>Today Expense</td>
                                    <td>{{ todayExpenseTotal }} Taka</td>
                                </tr>
                                <tr>
                                    <td class="text-success">Profit after Expense</td>
                                    <td class="text-success" v-if="profitAfterExpense > 0">{{ profitAfterExpense }} Taka</td>
                                    <td class="text-danger" v-else>{{ profitAfterExpense }} Taka</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div><br><br>

            </div>
          </div>

        </div>  
  </div>

</template>



<script type="text/javascript">
 export default { 

      created(){
            if(!User.loggedIn()){
              this.$router.push({ name: '/' })
            }else{
              this.todayReport()
            }
      },

      data(){
          return{
            todayExpenseTotal: '',         
            todayExpenses:{},  
            todaySell:'', 
            todayErnings:'',
            profitAfterExpense:''
          }
      },

      methods:{
        todayReport(){
          axios.get('/api/today-report')
          .then( ({data}) => {
              this.todayExpenseTotal = data[0] 
              this.todayExpenses = data[1] 
              this.todaySell = data[2] 
              this.todayErnings = data[3] 
              this.profitAfterExpense = (this.todayErnings - this.todayExpenseTotal) 
          })
        },



      }

  }
</script>



<style type="text/css">
	
  #imgstyle{
    height: 50px;
    border: 1px solid rgb(209 211 225);
    border-radius: 50%;
  }
  .dataTables_empty{
    display: none;
  }

</style>