const mongoose = require('mongoose')

const userSchema = new mongoose.Schema({
    name: String,
    email: String,
    code: String,
    createdIn: {
        type: Date,
        default: new Date()
    }
})

const generalUser = mongoose.model('generalUser', userSchema)
module.exports = generalUser