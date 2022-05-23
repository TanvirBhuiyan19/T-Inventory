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
            <router-link to="/expense">All Expense</router-link>
          </li>
          <li class="breadcrumb-item active">Add Expense</li>
        </ol>
        <!-- Icon Cards-->
       <div class="card shadow mb-4">
            <div class="card-header py-3">
				<span class="m-0 font-weight-bold text-primary">
					<i class="fas fa-chart-area"></i>
            		Expense Insert 
				</span>
            <router-link to="/expense" class="btn btn-sm btn-info" id="add_new"> All Expense</router-link>
          </div>
          <div class="card-body">
          	  <form @submit.prevent="expenseInsert" >

                <div class="form-group">
	              <div class="form-row">
	               <div class="col-md-12 col-sm-12">
	                <div class="form-label-group">
	                  <label for="details">Expense Details</label><span class="text-danger">*</span>
	                  <textarea type="text" v-model="form.details" class="form-control"  ></textarea>
	                  <small class="text-danger" v-if="errors.details">{{ errors.details[0] }}</small>
	                </div>
	               </div>
	             </div>
	          </div>
	          <div class="form-group">
	              <div class="form-row">
	               <div class="col-md-6 col-sm-12">
	                <div class="form-label-group">
	                  <label for="amount">Amount</label><span class="text-danger">*</span>
	                  <input type="number" v-model="form.amount" class="form-control" >
	                  <small class="text-danger" v-if="errors.amount">{{ errors.amount[0] }}</small>
	                </div>
	               </div>
	             </div>
	          </div>

               <button type="submit" class="btn btn-success">Submit</button>
              </form>
          </div>
          <br>
         </div>
       </div>
   </div>
</template>

<script type="text/javascript">
 export default { 
   created(){
     if(!User.loggedIn()){
       this.$router.push({ name: '/' })
     }
   },
  data(){
    return{
      form:{
        details :'',
        amount :'',
    },
      errors:{},
    }
  },

  methods:{

	expenseInsert(){
        axios.post('/api/expense/',this.form)
        .then(() => {
            this.$router.push({ name: 'expense' })
            Toast.fire({
                icon: 'success',
                title: 'Expense Added Successfully!'
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