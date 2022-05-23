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
            <router-link to="/give-salary">Employee List</router-link>
          </li>
          <li class="breadcrumb-item">
            <router-link to="/salary">Salary</router-link>
          </li>
          <li class="breadcrumb-item active">Give Salary</li>
        </ol>
        <!-- Icon Cards-->
       <div class="card shadow mb-4">
            <div class="card-header py-3">
				<span class="m-0 font-weight-bold text-primary">
					<i class="fas fa-chart-area"></i>
            		Give Salary to {{form.name}} 
				</span>
            <router-link to="/give-salary" class="btn btn-sm btn-info" id="add_new"> Employee List</router-link>
          </div>
          <div class="card-body">
          	  <form @submit.prevent="salaryInsert">
                <div class="form-group">
	              <div class="form-row">
	               <div class="col-md-6 col-sm-12">
	                <div class="form-label-group">
	                  <label for="firstName">Full Name</label>
	                  <p class="form-control"  >{{form.name}}</p>
	                </div>
	               </div>
	               <div class="col-md-6 col-sm-12">
	                <div class="form-label-group">
	                  <label for="lastName">Email Address</label>
					  <p class="form-control"  >{{form.email}}</p>
	                </div>
	               </div>
	             </div>
	          </div>
	          <div class="form-group">
	              <div class="form-row">
	               <div class="col-md-4 col-sm-12">
	                <div class="form-label-group">
	                  <label for="salaryMonth">Select Month</label><span class="text-danger">*</span>
	                  	<select class="form-control" id="exampleFormControlSelect1" v-model="form.salary_month">
                        <option selected disabled>Select a Month</option>
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
	                  <small class="text-danger" v-if="errors.salary_month">{{ errors.salary_month[0] }}</small>
	                </div>
	               </div>
				   <div class="col-md-4 col-sm-12">
	                <div class="form-label-group">
	                  <label for="phone">Phone Number</label>
					  <p class="form-control"  >{{form.phone}}</p>
	                </div>
	               </div>
	               <div class="col-md-4 col-sm-12">
	                <div class="form-label-group">
	                  <label for="lastName">Salary</label>
					  <p class="form-control"  >{{form.salary}}/-</p>
	                </div>
	               </div>
	             </div>
	          </div>

               <button type="submit" class="btn btn-success">Give Salary</button>
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
        email :'',
        salary:'',
        phone:'',
        salary_month:'',
    },
      errors:{},
    }
  },
   created(){
     if(!User.loggedIn()){
       this.$router.push({ name: '/' })
     }else{
         let id = this.$route.params.id
         axios.get('/api/employee/'+id)
         .then(({data}) => {
             this.form = data
         })
         .catch(console.log('error') )

     }
   },

  methods:{

	salaryInsert(){
		let id = this.$route.params.id
        axios.post('/api/salary/'+id,this.form)
        .then(() => {
            this.$router.push({ name: 'give-salary' })
            Toast.fire({
                icon: 'success',
                title: 'Salary Add Successfully!'
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