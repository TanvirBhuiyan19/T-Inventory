<template>

	<div>
     <!-- Begin Page Content -->
        <div class="container-fluid">

          <!-- Breadcrumbs-->
        <ol class="breadcrumb">
          <li class="breadcrumb-item">
            <router-link to="/home">Dashboard</router-link>
          </li>
          <li class="breadcrumb-item active">All Category</li>
        </ol>
          <!-- DataTales Example -->
          <div class="card shadow mb-4">
            <div class="card-header py-3">
              <span class="m-0 font-weight-bold text-primary">All Category List</span>
              <router-link to="/add-category" class="btn btn-sm btn-info" id="add_new"> Add Category</router-link>
            </div>
            <div class="card-body">
              <input type="text" v-model="formItem" class="form-control col-md-4 col-sm-12" placeholder="Search Category Name..." ><br>
              <div class="table-responsive">
                <table class="table table-bordered" id="" width="100%" cellspacing="0">
                  <thead>
                    <tr class="text-center">
                      <th>Category Name</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tfoot>
                    <tr class="text-center">
                      <th>Category Name</th>
                      <th>Action</th>
                    </tr>
                  </tfoot>
                  <tbody>
                    <tr v-for="category in filterSearch" :key="category.id" class="text-center">
                      <td>{{category.name}}</td>
                      <td>
                        <router-link :to="{ name: 'edit-category', params:{id: category.id} }" style="padding-right:5px" title="Edit"><i class="fa fa-edit text-success"></i></router-link>
                        <a @click="deleteSupplier(category.id)" title="Delete" style="cursor: pointer"><i class="fa fa-trash text-danger"></i></a>
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
              categories:[],
              formItem:'',
          }
      },

      computed:{
          filterSearch(){
            return this.categories.filter( category =>{
                  return category.name.toLowerCase().match(this.formItem.toLowerCase()) 
                  })
          },
  
      },

      methods:{
        allSupplier(){
          axios.get('/api/category')
          .then( ({data}) => {
              this.categories = data 
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
              axios.delete('/api/category/'+id)
              .then(()=>{
                 this.categories = this.categories.filter(category =>{
                    return category.id !=id
                 })
                 
                 Toast.fire({
                  icon: 'error',
                  title: 'Category Delete Successfully!'
                })

              })
              .catch(()=>{
                 this.$router.push({name: 'category'})
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