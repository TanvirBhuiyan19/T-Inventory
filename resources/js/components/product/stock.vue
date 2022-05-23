<template>

	<div>
     <!-- Begin Page Content -->
        <div class="container-fluid">

          <!-- Breadcrumbs-->
        <ol class="breadcrumb">
          <li class="breadcrumb-item">
            <router-link to="/home">Dashboard</router-link>
          </li>
          <li class="breadcrumb-item active">All Product</li>
        </ol>
          <!-- DataTales Example -->
          <div class="card shadow mb-4">
            <div class="card-header py-3">
              <span class="m-0 font-weight-bold text-primary">All Product List</span>
              <router-link to="/add-product" class="btn btn-sm btn-info" id="add_new"> Add Product</router-link>
            </div>
            <div class="card-body">
              <input type="text" v-model="formItem" class="form-control col-md-4 col-sm-12" placeholder="Search Product Name,Code,Category" ><br>
              <div class="table-responsive">
                <table class="table table-bordered" id="" width="100%" cellspacing="0">
                  <thead>
                    <tr class="text-center">
                      <th>Photo</th>
                      <th>Name</th>
                      <th>Code</th>
                      <th>Category</th>
                      <th>Status</th>
                      <th>Quantity</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tfoot>
                    <tr class="text-center">
                      <th>Photo</th>
                      <th>Name</th>
                      <th>Code</th>
                      <th>Category</th>
                      <th>Status</th>
                      <th>Quantity</th>
                      <th>Action</th>
                    </tr>
                  </tfoot>
                  <tbody>
                    <tr v-for="product in filterSearch" :key="product.id" class="text-center">
                      <td>
                        <img :src="'/backend/uploads/product/' + product.photo" width="50px"  :title=" 'Root: '+ product.root">
                      </td>
                      <td>{{product.name}}</td>
                      <td>{{product.code}}</td>
                      <td>{{product.category.name}}</td>
                      <td v-if="product.quantity > 0"><span class="badge badge-success">Availble</span></td>
                      <td v-else><span class="badge badge-danger">Stock Out</span></td>
                      <td>{{product.quantity}}</td>
                      <td>
                        <router-link :to="{ name: 'edit-stock', params:{id: product.id} }" style="padding-right:5px" title="Edit"><i class="fa fa-edit text-success"></i></router-link>
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
              this.allProduct()
            }
      },

      data(){
          return{
              products:[],
              formItem:'',
          }
      },

      computed:{
          filterSearch(){
            return this.products.filter( product =>{
                  return product.name.toLowerCase().match(this.formItem.toLowerCase()) || 
                        product.code.toLowerCase().match(this.formItem.toLowerCase()) || 
                        product.category.name.toLowerCase().match(this.formItem.toLowerCase())
                  })
          },
  
      },

      methods:{
        allProduct(){
          axios.get('/api/product')
          .then( ({data}) => {
              this.products = data 
          })
          .catch(error => {
              Toast.fire({
                icon: 'error',
                title: 'Something went wrong!'
              })

          })
        },
        deleteEmployee(id){
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
              axios.delete('/api/product/'+id)
              .then(()=>{
                 this.products = this.products.filter(product =>{
                    return product.id !=id
                 })

                 Toast.fire({
                  icon: 'error',
                  title: 'Product Delete Successfully!'
                })
                
              })
              .catch(()=>{
                 this.$router.push({name: 'product'})
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
    border-radius: 10%;
  }
  .dataTables_empty{
    display: none;
  }

</style>