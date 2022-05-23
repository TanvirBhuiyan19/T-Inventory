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
            <router-link to="/product">All Product</router-link>
          </li>
          <li class="breadcrumb-item active">Edit Product</li>
        </ol>
        <!-- Icon Cards-->
       <div class="card shadow mb-4">
            <div class="card-header py-3">
				<span class="m-0 font-weight-bold text-primary">
					<i class="fas fa-chart-area"></i>
            		Product Update 
				</span>
            <router-link to="/product" class="btn btn-sm btn-info" id="add_new"> All Product</router-link>
          </div>
          <div class="card-body">
          	  <form @submit.prevent="stockUpdate">
                
                <div class="form-group">
	              <div class="form-row">
	               <div class="col-md-6 col-sm-12">
	                <div class="form-label-group">
	                  <label for="productName">Product Name</label>
	                  <p class="form-control"  >{{form.name}}</p>
	                </div>
	               </div>
	               <div class="col-md-6 col-sm-12">
	                <div class="form-label-group">
	                  <label for="code">Code</label>
	                  <p class="form-control"  >{{form.code}}</p>
	                </div>
	               </div>
	             </div>
	          </div>

	          <div class="form-group">
	              <div class="form-row">
	               <div class="col-md-6 col-sm-12">
	                <div class="form-label-group">
	                  <label for="quantity">Quantity</label><span class="text-danger">*</span>
	                  <input type="number" v-model="form.quantity" class="form-control" >
	                  <small class="text-danger" v-if="errors.quantity">{{ errors.quantity[0] }}</small>
	                </div>
	               </div>
	             </div>
	          </div>

               <button type="submit" class="btn btn-success">Update</button>
              </form>
          </div>
          <br>
         </div>
       </div>
   </div>
</template>

<script type="text/javascript">
 export default { 
  
  data(){
    return{
      form:{
        name :'',
        code :'',
        category_id:'',
        quantity : ''
    },
      errors:{},
	  categories:'',
    }
  },
   created(){
     if(!User.loggedIn()){
       this.$router.push({ name: '/' })
     }else{

        let product_id = this.$route.params.id
         axios.get('/api/product/'+product_id)
         .then(({data}) => {
             this.form = data
        })
        .catch(console.log('error') )

		axios.get('/api/category/')
        .then(({data}) => {
            this.categories = data
        })

     }
   },

  methods:{

	stockUpdate(){
		let product_id = this.$route.params.id
        axios.post('/api/update-stock/'+product_id,this.form)
        .then(() => {
            this.$router.push({ name: 'stock' })
            Toast.fire({
                icon: 'success',
                title: 'Stock Update Successfully!'
            })
        })
       .catch(error => {
			this.errors = error.response.data.errors

			Toast.fire({
			icon: 'error',
			title: 'Invalid Credentials !!'
			})

		})

    },


  }


}
</script>

<style type="text/css">

	#add_new{
	float: right;
}

</style>