<template>

	<div>
     <!-- Begin Page Content -->
        <div class="container-fluid">

          <!-- Breadcrumbs-->
        <ol class="breadcrumb">
          <li class="breadcrumb-item">
            <router-link to="/home">Dashboard</router-link>
          </li>
          <li class="breadcrumb-item active">All Supplier</li>
        </ol>
          <!-- DataTales Example -->
          <div class="card shadow mb-4">
            <div class="card-header py-3">
              <span class="m-0 font-weight-bold text-primary">All Supplier List</span>
              <router-link to="/add-supplier" class="btn btn-sm btn-info" id="add_new"> Add Supplier</router-link>
            </div>
            <div class="card-body">
              <input type="text" v-model="formItem" class="form-control col-md-4 col-sm-12" placeholder="Search Supplier Name,Email,Phone,Shop name" ><br>
              <div class="table-responsive">
                <table class="table table-bordered" id="" width="100%" cellspacing="0">
                  <thead>
                    <tr class="text-center">
                      <th>Photo</th>
                      <th>Name</th>
                      <th>Email</th>
                      <th>Phone</th>
                      <th>Shop Name</th>
                      <th>Shop Address</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tfoot>
                    <tr class="text-center">
                      <th>Photo</th>
                      <th>Name</th>
                      <th>Email</th>
                      <th>Phone</th>
                      <th>Shop Name</th>
                      <th>Shop Address</th>
                      <th>Action</th>
                    </tr>
                  </tfoot>
                  <tbody>
                    <tr v-for="supplier in filterSearch" :key="supplier.id" class="text-center">
                      <td>
                        <img :src="'/backend/uploads/supplier/' + supplier.photo" id="imgstyle">
                      </td>
                      <td>{{supplier.name}}</td>
                      <td>{{supplier.email}}</td>
                      <td>{{supplier.phone}}</td>
                      <td>{{supplier.shop_name}}</td>
                      <td>{{supplier.address}}</td>
                      <td>
                        <router-link :to="{ name: 'edit-supplier', params:{id: supplier.id} }" style="padding-right:5px" title="Edit"><i class="fa fa-edit text-success"></i></router-link>
                        <a @click="deleteSupplier(supplier.id)" title="Delete" style="cursor: pointer"><i class="fa fa-trash text-danger"></i></a>
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
              this.allSupplier()
            }
      },

      data(){
          return{
              suppliers:[],
              formItem:'',
          }
      },

      computed:{
          filterSearch(){
            return this.suppliers.filter( supplier =>{
                      return supplier.name.toLowerCase().match(this.formItem.toLowerCase()) || 
                            supplier.phone.match(this.formItem) ||
                            supplier.email.match(this.formItem) ||
                            supplier.shop_name.toLowerCase().match(this.formItem.toLowerCase()) ||
                            supplier.address.toLowerCase().match(this.formItem.toLowerCase()) 
                      })
          },
  
      },

      methods:{
        allSupplier(){
          axios.get('/api/supplier')
          .then( ({data}) => {
              this.suppliers = data 
          })
          .catch(error => {
              Toast.fire({
                icon: 'error',
                title: 'Something went wrong!'
              })

          })
        },
        deleteSupplier(id){
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
              axios.delete('/api/supplier/'+id)
              .then(()=>{
                 this.suppliers = this.suppliers.filter(supplier =>{
                    return supplier.id !=id
                 })
                 
                 Toast.fire({
                  icon: 'error',
                  title: 'Supplier Delete Successfully!'
                })

              })
              .catch(()=>{
                 this.$router.push({name: 'supplier'})
              })
              // Swal.fire(
              //   'Deleted!',
              //   'Your file has been deleted.',
              //   'success'
              // )
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