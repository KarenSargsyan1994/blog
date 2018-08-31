import React, {Component} from 'react';
import ReactDOM from 'react-dom';
import axios from 'axios';
import 'bootstrap/dist/css/bootstrap.min.css';

class Edit extends Component {

    constructor(props) {
        super(props)
        this.state = {
            userObj: props.userObj,
        }
        this.saveUser = this.saveUser.bind(this)
    }

    editUser() {
        this.props.handleSubmit2(this.state.userObj)
    }


    saveUser(userObj) {

        this.props.handleSubmit(this.state.userObj)
    }

    render() {
        return (
            <div>
                {this.state.userObj.editable == true ?
                    <button type="button"
                            className="btn btn-success"
                            onClick={this.saveUser.bind(this)}
                    >Save</button>

                    : <button type="button"
                              className="btn btn-warning"
                              onClick={this.editUser.bind(this, this.state.userObj)}
                    >Edit</button>
                }

            </div>
        );
    }


}

export default Edit;