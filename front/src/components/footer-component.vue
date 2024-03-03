<script setup lang="ts">
import PhoneNumber from './shared/phone-number.vue'

const linksSocial = [
  {
    link: 'https://vk.com/iquest',
    img: 'vk.svg',
  },
  {
    link: 'https://t.me/questtomsk',
    img: 'telegram.svg',
  },
  {
    link: 'https://www.youtube.com/channel/UCiEXe3D9fy8GX9X73lpxOxA?disable_polymer=true',
    img: 'youtube.svg',
  },
]

const linkASAP = 'https://asapeducation.ru/?utm_course=iquest_site'

const emainAddress = {
  text: 'iquest.tsk@gmail.com',
  img: 'mail.svg',
}
</script>

<template>
  <footer class="border">
    <div class="container footer">
      <img src="/logo/logo_full.svg" alt="logo">
      <div class="footer-links">
        <div class="footer-links__contacts">
          <PhoneNumber />
          <span class="body">
            <img
              :src="`/icons/share/${emainAddress.img}`"
              :alt="emainAddress.img"
            >
            {{ emainAddress.text }}
          </span>
        </div>
        <div class="footer-links__social">
          <a
            v-for="link in linksSocial"
            :key="link.img"
            target="_blank"
            :href="link.link"
          >
            <img :src="`/icons/social/${link.img}`" :alt="link.img">
          </a>
        </div>
      </div>
      <div class="footer-privacy">
        <p class="smallFootnote">
          Политика конфиденциальности
        </p>
        <span class="smallFootnote">
          Разработано в
          <a :href="linkASAP" target="_blank">
            <img src="/logo/asapLogo.svg" alt="asapLogo">
          </a>
        </span>
      </div>
    </div>
  </footer>
</template>

<style scoped lang="scss">
.border {
  border-top: 2px solid $color-shade-6 !important;
  background-image: url("/gradient/footer-gradient.svg");
  background-repeat: no-repeat;
  background-position: center top;
  margin-top: 108px;
}

.footer {
  height: 100%;
  margin-inline: auto;
  padding: 72px 88px;
  justify-content: space-between;
  max-height: 282px;

  &-links {
    display: flex;
    flex-direction: column;
    justify-content: space-between;

    &__contacts {
      display: flex;
      flex-direction: column;
      gap: 12px;

      span {
        display: flex;
        gap: 8px;
      }
    }

    &__social {
      display: flex;
      gap: 16px;
      align-items: flex-start;
    }
  }

  &-privacy {
    justify-content: space-between;
    display: flex;
    flex-direction: column;
    align-items: flex-end;
    color: $color-base2;

    span {
      display: flex;
      align-items: center;
      gap: 8px;
    }
  }
}
</style>
