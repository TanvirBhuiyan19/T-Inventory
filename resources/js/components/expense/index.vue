<template>

	<div>
     <!-- Begin Page Content -->
        <div class="container-fluid">

          <!-- Breadcrumbs-->
        <ol class="breadcrumb">
          <li class="breadcrumb-item">
            <router-link to="/home">Dashboard</router-link>
          </li>
          <li class="breadcrumb-item active">All Expense</li>
        </ol>
          <!-- DataTales Example -->
          <div class="card shadow mb-4">
            <div class="card-header py-3">
              <span class="m-0 font-weight-bold text-primary">All Expense List</span>
              <router-link to="/add-expense" class="btn btn-sm btn-info" id="add_new"> Add Expense</router-link>
            </div>
            <div class="card-body">
              <input type="text" v-model="formItem" class="form-control col-md-4 col-sm-12" placeholder="Search Expense Date, Details" ><br>
              <div class="table-responsive">
                <table class="table table-bordered" id="" width="100%" cellspacing="0">
                  <thead>
                    <tr class="text-center">
                      <th>Details</th>
                      <th>Amount</th>
                      <th>Expense Date</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tfoot>
                    <tr class="text-center">
                      <th>Details</th>
                      <th>Amount</th>
                      <th>Expense Date</th>
                      <th>Action</th>
                    </tr>
                  </tfoot>
                  <tbody>
                    <tr v-for="expense in filterSearch" :key="expense.id" class="text-center">
                      <td>{{expense.details}}</td>
                      <td>{{expense.amount}}</td>
                      <td>{{expense.expense_date}}</td>
                      <td>
                        <router-link :to="{ name: 'edit-expense', params:{id: expense.id} }" style="padding-right:5px" title="Edit"><i class="fa fa-edit text-success"></i></router-link>
                        <a @click="deleteExpense(expense.id)" title="Delete" style="cursor: pointer"><i class="fa fa-trash text-danger"></i></a>
                      </td>
                    </tr>
                  </tbody>
                </table>
              </div>
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
              this.allExpense()
            }
      },

      data(){
          return{
              expenses:[],
              formItem:'',
          }
      },

      computed:{
          filterSearch(){
            return this.expenses.filter( expense =>{
                      return expense.details.toLowerCase().match(this.formItem.toLowerCase()) || 
                            expense.expense_date.match(this.formItem)
                      })
          },
  
      },

      methods:{
        allExpense(){
          axios.get('/api/expense')
          .then( ({data}) => {
              this.expenses = data 
          })
          .catch(error => {
              Toast.fire({
                icon: 'error',
                title: 'Something went wrong!'
              })

          })
        },
        deleteExpense(id){
            Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
          }).then((result) => {
            if (result.value) {
              axios.delete('/api/expense/'+id)
              .then(()=>{
                 this.expenses = this.expenses.filter(expense =>{
                    return expense.id !=id
                 })

                 Toast.fire({
                  icon: 'success',
                  title: 'Expense Delete Successfully!'
                })
                
              })
              .catch(()=>{
                 this.$router.push({name: 'expense'})
              })

            }
           })
          }

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