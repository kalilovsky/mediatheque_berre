<template>
  <div class="card" >
		<div class="imgBx">
			<!-- <img src="../assets/Apocalypto-DVD.jpg"> -->
			<!-- <img src="../assets/Bach-The-Art-Of-Life.jpg"> -->
			<!-- <img src="../assets/Demon-Slayer.jpg"> -->
			<img :src="'http://localhost:3000/public/articlefile/'+url">
		</div>
		<div class="contentBx">
            <slot></slot>
			<h3>{{title}}</h3>
            <hr>
			<h2 class="price">'{{author}}'</h2>
			<a href="#" class="buy">Prendre</a> 
		</div>
        <p>{{subCat}}</p>
	</div>
</template>

<script>

export default {
    props:['url','title','subCat','author'],
    data(){
        return({
            text:"test",
        })
    },
    component:{
    }

}
</script>

<style lang="scss">
.card
{
    position: relative;
    width: 250px;
    height: 420px;
    background: #122936;
    border-radius: 20px;
    overflow: hidden;
    margin: 20px 0;
    justify-self: center;
    p
    {
        z-index: 0;
        position: absolute;
        bottom: 0;
        left: 0;
        color: rgba(0,0,0,0.1);
        font-weight: 600;
        font-size: 8em;
        transition: 0.5s;
    }
}
.card:before
{
    content: '';
    position: absolute;
    top: -50%;
    left: 0;
    width: 100%;
    height: 100%;
    background: #2196f3;
    transform: skewY(345deg);
    transition: 0.5s;
}
.card:hover:before
{
    transform: skewY(390deg);
}

.card .imgBx
{
    position: relative;
    width: 100%;
    display: flex;
    justify-content: center;
    align-items: center;
    /* padding-top: 20px; */
    z-index: 2;
    height: 310px;
    overflow: hidden;
    transition: 0.5s;
    
}
.card .imgBx img
{
    position: absolute;
    max-width: 100%;
    transition: 0.5s;
}
.card:hover 
{
    .imgBx
    {
        height: 260px;
        img{
            transform: scale(50%);
        }
    }
    .contentBx{
        .buy{
            opacity: 1;
            transform: translateY(-200px);
        }
        .myTag{
            position: absolute;
            transform: translateY(-100px);
            opacity: 1;
        }
    }
}
.card .contentBx
{
    position: relative;
    padding: 20px;
    display: flex;
    justify-content: center;
    align-items: center;
    flex-direction: column;
    z-index: 1;
    .myTag{
        position: absolute;
        transform: translateY(-200px);
        transition: 0.5s;
        opacity: 0;
    }
    hr {
        border-top: 0px solid #fff;
        overflow: visible;
        text-align: center;
        height: 0px;
        width: 100%;
        margin: 10px 0;
    }
}
.card .contentBx h3
{
    font-size: 18px;
    color: #fff;
    font-weight: 500;
    text-transform: uppercase;
    letter-spacing: 1px;
    overflow: hidden;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    display: -webkit-box;
    text-overflow: ellipsis;
}
.card .contentBx .price
{
    font-size: 16px;
    color: #fff;
    font-weight: 500;
    text-transform: uppercase;
    letter-spacing: 1px;
}
.card .contentBx .buy
{
    position: relative;
    top: 200px;
    padding: 10px 30px;
    margin-top: 15px;
    color: #fff;
    text-decoration: none;
    border-radius: 30px;
    background: #2196f3;
    opacity: 0;
    text-transform: uppercase;
    letter-spacing: 1px;
    transition: 0.5s;
}

</style>