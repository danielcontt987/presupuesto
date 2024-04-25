<template>
  <div class="overlay">
    <div class="content">
        <slot></slot>
    </div>
  </div>
</template>

<style scoped>
    
.overlay {
  position: absolute;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background: linear-gradient(
    to bottom,
    rgba(0, 0, 0, 0.5) 0%,
    rgba(6, 6, 6, 0.568) 100%
  );
  z-index: 1000;
}

.content {
  position: absolute;
  top: 50%;
  left: 50%;
  transform: translate(-50%, -50%);
  text-align: center;
  color: white;
}
</style>