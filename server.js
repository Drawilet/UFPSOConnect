if (process.env.NODE_ENV !== "production") {
    require("dotenv").config()
}

const express = require("express")
const mongoose = require("mongoose")
const generalUser = require ("./models/user")
const app = express()


const uri = 'mongodb+srv://JefersonMesa:Piolin98@ufpsoconnectcluster.eisgl4l.mongodb.net/?retryWrites=true&w=majority&appName=UFPSOConnectCluster'

//Importing bcrypt
const bcrypt = require("bcrypt")
const initializePassport = require("./passport-config")
const flash = require("express-flash")
const session = require("express-session")
const passport = require("passport")
const methodOverride = require("method-override")

initializePassport(
    passport,
    email => users.find(user => user.email === email),
    id => users.find(user => user.id === id)
    )       

async function connect() {
    try {
        await mongoose.connect(uri)
    } catch (e) {

    }
}

const users = []

app.use(express.urlencoded({extended: false}))
app.use(flash())
app.use(session({
    secret: process.env.SESSION_SECRET,
    resave: false,
    saveUninitialized: false
}))
app.use(passport.initialize())
app.use(passport.session())
app.use(methodOverride("_method"))

//Config of the login post
app.post("/login",checkUnAuthenticated, passport.authenticate("local", {
    successRedirect: "/",
    failureRedirect: "/login",
    failureFlash: true,
}))

// Config of the register post
app.post("/register",checkUnAuthenticated, async (req, res) => {

    try {
        const hashedPassword = await bcrypt.hash(req.body.password, 10)
        users.push({
            id: Date.now().toString(), //Get specify ID
            name: req.body.name,
            email: req.body.email,
            code: req.body.code,
            password: hashedPassword, //send encrypted password
        })
        res.redirect("/login")
        console.log(users);
    } catch (e) {
        console.log(e);
        res.redirect("/register")
    }

})

//Routes
app.get('/', checkAuthenticated,(req, res) => {
    res.render("index.ejs", {name: req.user.name})
})

app.get('/login',checkUnAuthenticated, (req, res) => {
    res.render("login.ejs")
})

app.get('/register', checkUnAuthenticated, (req, res) => {
    res.render("register.ejs")
})

app.use(express.static("public"));  //connect css and public folder

    

//End Routes



function checkAuthenticated(req, res, next) {
    if(req.isAuthenticated()) {
        return next()
    }
    res.redirect("/login")
}

function checkUnAuthenticated(req, res, next) {
    if(req.isAuthenticated()) {
        return res.redirect("/")
    }
    next()
}

connect();

app.listen(3000)