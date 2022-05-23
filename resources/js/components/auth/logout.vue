<template>

</template>

<script type="text/javascript">
 export default { 
   created(){
    User.loggedOut();

     Toast.fire({
          icon: 'warning',
          title: 'Logout Successfully!'
        })

        this.$router.push({ name: '/' })

  }


}
</script>

<style type="text/css">
	
</style>