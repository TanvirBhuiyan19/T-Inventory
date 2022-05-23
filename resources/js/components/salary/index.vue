<template>

	<div>
     <!-- Begin Page Content -->
        <div class="container-fluid">

          <!-- Breadcrumbs-->
        <ol class="breadcrumb">
          <li class="breadcrumb-item">
            <router-link to="/home">Dashboard</router-link>
          </li>
          <li class="breadcrumb-item active">All Salary</li>
        </ol>
          <!-- DataTales Example -->
          <div class="card shadow mb-4">
            <div class="card-header py-3">
              <span class="m-0 font-weight-bold text-primary">All Salary List</span>
              <router-link to="/give-salary" class="btn btn-sm btn-info" id="add_new"> Give Salary</router-link>
            </div>
            <div class="card-body">
              <div class="row">
              <input type="text" v-model="formItem" class="form-control col-md-4 col-sm-12" placeholder="Search Employee Name,Email,Phone,Month" ><br>
                <select v-model="salaryYear"   class="form-control col-md-1 col-sm-12" id="exampleFormControlSelect1">
                  <option value="">All Year</option>
                  <option :value="year.salary_year" v-for="year in salary_year" :key="year.salary_year">{{year.salary_year}}</option>
                </select>
              </div>
              <br>
              <div class="table-responsive">
                <table class="table table-bordered" id="" width="100%" cellspacing="0">
                  <thead>
                    <tr class="text-center">
                      <th>Photo</th>
                      <th>Name</th>
                      <th>Email</th>
                      <th>Phone</th>
                      <th>Salary</th>
                      <th>Month</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tfoot>
                    <tr class="text-center">
                      <th>Photo</th>
                      <th>Name</th>
                      <th>Email</th>
                      <th>Phone</th>
                      <th>Salary</th>
                      <th>Month</th>
                      <th>Action</th>
                    </tr>
                  </tfoot>
                  <tbody>
                    <tr v-for="salary in filterSearch" :key="salary.id" class="text-center">
                      <td>
                        <img :src="'/backend/uploads/employee/' + salary.employee.photo" id="imgstyle">
                      </td>
                      <td>{{salary.employee.name}}</td>
                      <td>{{salary.employee.email}}</td>
                      <td>{{salary.employee.phone}}</td>
                      <td>{{salary.employee.salary}}</td>
                      <td>{{salary.salary_month}}</td>
                      <td>
                        <router-link :to="{ name: 'edit-salary', params:{id: salary.id} }" style="padding-right:5px" title="Edit"><i class="fa fa-edit text-success"></i></router-link>
                        <a @click="deleteSalarie(salary.id)" title="Delete" style="cursor: pointer"><i class="fa fa-trash text-danger"></i></a>
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
              this.allSalarie()
            }
      },

      data(){
          return{
              salaries:[],
              salary_year:[],
              formItem:'',
              salaryYear:'',
          }
      },

      computed:{
          filterSearch(){
            return this.salaries.filter( salary =>{
              
                if(this.formItem && !(this.salaryYear) ){
                      return salary.employee.name.toLowerCase().match(this.formItem.toLowerCase()) || 
                      salary.employee.phone.match(this.formItem) ||
                      salary.employee.email.toLowerCase().match(this.formItem.toLowerCase()) ||
                      salary.salary_month.toLowerCase().match(this.formItem.toLowerCase())

                  }else if( this.salaryYear && this.formItem ){

                        if( salary.employee.name.toLowerCase().match(this.formItem.toLowerCase()) ){
                                return salary.employee.name.toLowerCase().match(this.formItem.toLowerCase()) && 
                                        salary.salary_year.match(this.salaryYear)

                        }else if(salary.employee.phone.match(this.formItem)){
                                return salary.employee.phone.match(this.formItem) &&
                                        salary.salary_year.match(this.salaryYear)

                        }else if( salary.employee.email.toLowerCase().match(this.formItem.toLowerCase()) ){
                                return salary.employee.email.toLowerCase().match(this.formItem.toLowerCase()) &&
                                        salary.salary_year.match(this.salaryYear)

                        }else if( salary.salary_month.toLowerCase().match(this.formItem.toLowerCase()) ){
                                return salary.salary_month.toLowerCase().match(this.formItem.toLowerCase()) &&
                                        salary.salary_year.match(this.salaryYear)
                        }
                      

                  }else{
                      return  salary.salary_year.match(this.salaryYear)
                      
                  }
                    

                })
          },
  
      },

      methods:{
        allSalarie(){
          axios.get('/api/salary')
          .then( ({data}) => {
              this.salaries = data[0]
              this.salary_year = data[1]
          })
          .catch(error => {
              Toast.fire({
                icon: 'error',
                title: 'Something went wrong!'
              })

          })
        },
        deleteSalarie(id){
            Swal.fire({
              title: 'Are you sure?',
              text: "You won't be able to revert this!",
              type: 'warning',
              showCancelButton: true,
              confirmButtonColor: '#3085d6',
              cancelButtonColor: '#d33',
              confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
              if(result.value) {
                axios.delete('/api/salary/'+id)
                .then(()=>{
                  this.salaries = this.salaries.filter(salary =>{
                      return salary.id !=id
                  })
                  
                  Toast.fire({
                    icon: 'success',
                    title: 'Salary Delete Successfully!'
                  })

                })
                .catch(()=>{
                  this.$router.push({name: 'salary'})
                })
              }
            })
          }

      }

  }
</script>



<style type="text/css">
	
  .dataTables_empty{
    display: none;
  }

</style>