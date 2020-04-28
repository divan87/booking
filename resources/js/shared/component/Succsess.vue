<template>
  <div class="text-center succsess">
    <i class="far fa-thumbs-up"></i>
    <h1 class="mt-4">Succsess!</h1>
    <h2><slot></slot></h2>    
  </div>
</template>

<style scoped>
.succsess {
  color: #999;
  font-size: 10rem;
}
</style>