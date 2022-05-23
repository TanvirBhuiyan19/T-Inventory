<template>

	<div>
     <!-- Begin Page Content -->
        <div class="container-fluid">

          <!-- Breadcrumbs-->
        <ol class="breadcrumb">
          <li class="breadcrumb-item">
            <router-link to="/home">Dashboard</router-link>
          </li>
          <li class="breadcrumb-item active">Search Report</li>
        </ol>
          <!-- DataTales Example -->
          <div class="card shadow mb-4">
            <div class="card-header py-3">
              <span class="m-0 font-weight-bold text-primary">Search Report</span>

              <a :href="'/api/report-by-month-pdf/'+month " target="_blank" class="btn btn-sm btn-primary" id="add_new" v-if="month != '' && year == '' && date == '' && filterSearch != '' "> Generate PDF</a>
              <a :href="'/api/report-by-year-pdf/'+year " target="_blank" class="btn btn-sm btn-primary" id="add_new" v-else-if="year != '' && month == '' && date == '' && filterSearch != '' "> Generate PDF</a>
              <a :href="'/api/report-by-month-year-pdf/'+month +'/'+year " target="_blank" class="btn btn-sm btn-primary" id="add_new" v-else-if="year != '' && month != '' && date == '' && filterSearch != '' "> Generate PDF</a>
              <a :href="'/api/report-by-date-pdf/'+reportDate " target="_blank" class="btn btn-sm btn-primary" id="add_new" v-else-if="date != '' && year == '' && month == '' && filterSearch != '' "> Generate PDF</a>
              
            </div>
            <div class="card-body">
              <small class="fa fa-refresh" @click.prevent="clearDate()" style="cursor:pointer">Clear Date</small>
              <div class="row">
              <input type="date" v-model="reportDate" class="form-control col-md-3 col-sm-12" ><br>
                <select v-model="reportMonth"   class="form-control col-md-2 col-sm-12" id="exampleFormControlSelect1">
                    <option value="" >All Month</option>
                        <option value="January">January</option>
                        <option value="February">February</option>
                        <option value="March">March</option>
                        <option value="April">April</option>
                        <option value="May">May</option>
                        <option value="June">June</option>
                        <option value="July">July</option>
                        <option value="August">August</option>
                        <option value="September">September</option>
                        <option value="October">October</option>
                        <option value="November">November</option>
                        <option value="December">December</option>
                </select>
                <select v-model="reportYear"   class="form-control col-md-2 col-sm-12" id="exampleFormControlSelect1">
                  <option value="">All Year</option>
                  <option :value="year.order_year" v-for="year in order_years" :key="year.order_year">{{year.order_year}}</option>
                </select>

                <button  class="btn btn-sm btn-success form-control col-md-2 col-sm-12" v-if="reportMonth != '' && reportYear == '' && reportDate == '' " @click.prevent="searchByMonth()" >Search</button>
                <button  class="btn btn-sm btn-success form-control col-md-2 col-sm-12" v-else-if="reportYear != '' && reportMonth == '' && reportDate == '' " @click.prevent="searchByYear()" >Search</button>
                <button  class="btn btn-sm btn-success form-control col-md-2 col-sm-12" v-else-if="reportYear != '' && reportMonth != '' && reportDate == '' " @click.prevent="searchByMonthYear()" >Search</button>
                <button  class="btn btn-sm btn-success form-control col-md-2 col-sm-12" v-else-if="reportDate != '' && reportYear == '' && reportMonth == '' " @click.prevent="searchByDate()" >Search</button>
                
              </div>
              <br>

            <h3 class="text-center" v-if="month != '' || year != '' || date!= '' ">Report of {{ month }} {{ year }} {{ date }}</h3>
                <div class="row">
                    <div class="col-md-6 col-sm-12 m-auto">
                        <table class="table table-bordered" id="" width="100%" cellspacing="0">
                            <tbody v-if="SellTotal != '' ">
                                <tr>
                                    <td>Total Sell</td>
                                    <td>{{ SellTotal }} Taka</td>
                                </tr>
                                <tr>
                                    <td>Total Profit</td>
                                    <td>{{ ErningsTotal }} Taka</td>
                                </tr>
                                <tr>
                                    <td>Total Expense</td>
                                    <td>{{ ExpenseTotal }} Taka</td>
                                </tr>
                                <tr v-if="reportDate == '' ">
                                    <td>Total Salary Given</td>
                                    <td>{{ SalaryTotal }} Taka</td>
                                </tr>
                                <tr>
                                    <td class="text-success">Profit after all Expense</td>
                                    <td class="text-success" v-if="profitAfterExpense > 0">{{ profitAfterExpense }} Taka</td>
                                    <td class="text-danger" v-else>{{ profitAfterExpense }} Taka</td>
                                </tr>
                            </tbody>
                            <tbody v-else>
                                <tr class="text-center">
                                    <td><h3 style="margin: 50px">No Data Found!</h3></td>
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
              this.reportYears()
            }
      },

      data(){
          return{
              order_years:{},
              reportDate:'',
              reportMonth:'',
              reportYear:'',
              ExpenseTotal: '',       
              SalaryTotal: '',
              SellTotal:'', 
              ErningsTotal:'',
              profitAfterExpense:'',
              month: '',
              year: '',
              date: ''
          }
      },

      methods:{
        reportYears(){
          axios.get('/api/report-years')
          .then( ({data}) => { 
              this.order_years = data
          })
          .catch(error => {
              Toast.fire({
                icon: 'error',
                title: 'Something went wrong!'
            })
          })
        },
          clearDate(){
                 this.reportDate = ''
          },

        searchByDate(){
              axios.get('/api/report-by-date/'+this.reportDate)
                .then( ({data}) => {
                    this.ExpenseTotal = data[0] 
                    this.SellTotal = data[1]
                    this.ErningsTotal = data[2] 
                    this.profitAfterExpense = (this.ErningsTotal - this.ExpenseTotal)
                    this.date = data[3] 
                    this.month = ''
                    this.year = ''
                })
          },
          searchByMonth(){
              axios.get('/api/report-by-month/'+this.reportMonth)
                .then( ({data}) => {
                    this.ExpenseTotal = data[0] 
                    this.SalaryTotal = data[1] 
                    this.SellTotal = data[2]
                    this.ErningsTotal = data[3] 
                    this.profitAfterExpense = (this.ErningsTotal - this.ExpenseTotal - this.SalaryTotal)
                    this.month = this.reportMonth
                    this.year = ''
                    this.date = ''
                })
          },
          searchByYear(){
              axios.get('/api/report-by-year/'+this.reportYear)
                .then( ({data}) => {
                    this.ExpenseTotal = data[0] 
                    this.SalaryTotal = data[1] 
                    this.SellTotal = data[2]
                    this.ErningsTotal = data[3] 
                    this.profitAfterExpense = (this.ErningsTotal - this.ExpenseTotal - this.SalaryTotal)
                    this.year = this.reportYear
                    this.month = ''
                    this.date = ''
                })
          },
          searchByMonthYear(){
              axios.get('/api/report-by-month-year/'+this.reportMonth +'/'+this.reportYear)
                .then( ({data}) => {
                    this.ExpenseTotal = data[0] 
                    this.SalaryTotal = data[1] 
                    this.SellTotal = data[2]
                    this.ErningsTotal = data[3] 
                    this.profitAfterExpense = (this.ErningsTotal - this.ExpenseTotal - this.SalaryTotal)
                    this.month = this.reportMonth
                    this.year = this.reportYear
                    this.date = ''
                    this.reportMonth = ''
                    this.reportYear = ''
                })
          },




      }

  }
</script>



<style type="text/css">
	
  .dataTables_empty{
    display: none;
  }

</style>