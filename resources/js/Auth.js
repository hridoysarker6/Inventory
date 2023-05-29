export default (to, from, next) => {
   
     const publicPages = ['/login'];
     const authRequired = !publicPages.includes(to.path);
      
     if (authRequired && !isAuthenticated()) {
       next('/login'); 
     }else{
       next('home');
     }
  }
  