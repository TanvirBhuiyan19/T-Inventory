<template>

	<div>
     <!-- Begin Page Content -->
        <div class="container-fluid">

          <!-- Breadcrumbs-->
        <ol class="breadcrumb">
          <li class="breadcrumb-item">
            <router-link to="/home">Dashboard</router-link>
          </li>
          <li class="breadcrumb-item">
            <router-link to="/salary">Salary</router-link>
          </li>
          <li class="breadcrumb-item active">All Employee</li>
        </ol>
          <!-- DataTales Example -->
          <div class="card shadow mb-4">
            <div class="card-header py-3">
              <span class="m-0 font-weight-bold text-primary">All Employee List</span>
              <router-link to="/salary" class="btn btn-sm btn-info" id="add_new"> All Salary</router-link>
            </div>
            <div class="card-body">
              <input type="text" v-model="formItem" class="form-control col-md-4 col-sm-12" placeholder="Search Employee Name,Email,Phone,Salary" ><br>
              <div class="table-responsive">
                <table class="table table-bordered" id="" width="100%" cellspacing="0">
                  <thead>
                    <tr class="text-center">
                      <th>Photo</th>
                      <th>Name</th>
                      <th>Email</th>
                      <th>Phone</th>
                      <th>Salary</th>
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
                      <th>Action</th>
                    </tr>
                  </tfoot>
                  <tbody>
                    <tr v-for="employee in filterSearch" :key="employee.id" class="text-center">
                      <td>
                        <img :src="'/backend/uploads/employee/' + employee.photo" id="imgstyle">
                      </td>
                      <td>{{employee.name}}</td>
                      <td>{{employee.email}}</td>
                      <td>{{employee.phone}}</td>
                      <td>{{employee.salary}}</td>
                      <td>
                        <router-link :to="{ name: 'add-salary', params:{id: employee.id} }" style="padding-right:5px" title="Give Salary"><h4 style="padding:0px; margin:0px"><i class="fas fa-hand-holding-usd text-success"></i></h4></router-link>
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
              this.allEmployee()
            }
      },

      data(){
          return{
              employees:[],
              formItem:'',
          }
      },

      computed:{
          filterSearch(){
            return this.employees.filter( employee =>{
                      return employee.name.toLowerCase().match(this.formItem.toLowerCase()) || 
                            employee.phone.match(this.formItem) ||
                            employee.email.match(this.formItem) ||
                            employee.salary.match(this.formItem) 
                      })
          },
  
      },

      methods:{
        allEmployee(){
          axios.get('/api/employee')
          .then( ({data}) => {
              this.employees = data 
          })
          .catch(error => {
              Toast.fire({
                icon: 'error',
                title: 'Something went wrong!'
              })

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