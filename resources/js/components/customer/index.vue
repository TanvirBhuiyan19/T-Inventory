<template>

	<div>
     <!-- Begin Page Content -->
        <div class="container-fluid">

          <!-- Breadcrumbs-->
        <ol class="breadcrumb">
          <li class="breadcrumb-item">
            <router-link to="/home">Dashboard</router-link>
          </li>
          <li class="breadcrumb-item active">All Customer</li>
        </ol>
          <!-- DataTales Example -->
          <div class="card shadow mb-4">
            <div class="card-header py-3">
              <span class="m-0 font-weight-bold text-primary">All Customer List</span>
              <router-link to="/add-customer" class="btn btn-sm btn-info" id="add_new"> Add Customer</router-link>
            </div>
            <div class="card-body">
              <input type="text" v-model="formItem" class="form-control col-md-4 col-sm-12" placeholder="Search Customer Name,Email,Phone,Address" ><br>
              <div class="table-responsive">
                <table class="table table-bordered" id="" width="100%" cellspacing="0">
                  <thead>
                    <tr class="text-center">
                      <th>Photo</th>
                      <th>Name</th>
                      <th>Email</th>
                      <th>Phone</th>
                      <th>Address</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tfoot>
                    <tr class="text-center">
                      <th>Photo</th>
                      <th>Name</th>
                      <th>Email</th>
                      <th>Phone</th>
                      <th>Address</th>
                      <th>Action</th>
                    </tr>
                  </tfoot>
                  <tbody>
                    <tr v-for="customer in filterSearch" :key="customer.id" class="text-center">
                      <td>
                        <img :src="'/backend/uploads/customer/' + customer.photo" id="imgstyle">
                      </td>
                      <td>{{customer.name}}</td>
                      <td>{{customer.email}}</td>
                      <td>{{customer.phone}}</td>
                      <td>{{customer.address}}</td>
                      <td>
                        <router-link :to="{ name: 'edit-customer', params:{id: customer.id} }" style="padding-right:5px" title="Edit"><i class="fa fa-edit text-success"></i></router-link>
                        <a @click="deleteCustomer(customer.id)" title="Delete" style="cursor: pointer"><i class="fa fa-trash text-danger"></i></a>
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
              this.allCustomer()
            }
      },

      data(){
          return{
              customers:[],
              formItem:'',
          }
      },

      computed:{
          filterSearch(){
            return this.customers.filter( customer =>{
                      return customer.name.toLowerCase().match(this.formItem.toLowerCase()) || 
                            customer.email.toLowerCase().match(this.formItem.toLowerCase()) || 
                            customer.address.toLowerCase().match(this.formItem.toLowerCase()) || 
                            customer.phone.match(this.formItem) 
                      })
          },
  
      },

      methods:{
        allCustomer(){
          axios.get('/api/customer')
          .then( ({data}) => {
              this.customers = data 
          })
          .catch(error => {
              Toast.fire({
                icon: 'error',
                title: 'Something went wrong!'
              })

          })
        },
        deleteCustomer(id){
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
              axios.delete('/api/customer/'+id)
              .then(()=>{
                 this.customers = this.customers.filter(customer =>{
                    return customer.id !=id
                 })

                 Toast.fire({
                  icon: 'error',
                  title: 'Customer Delete Successfully!'
                })
                
              })
              .catch(()=>{
                 this.$router.push({name: 'customer'})
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