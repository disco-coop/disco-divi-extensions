// External Dependencies
import React, {Component, Fragment} from 'react';

// Internal Dependencies
import './style.css';


class DiscoLink extends Component {

  static slug = 'disco_link';

  render() {
    const Content = this.props.content;
    const URL = this.props.url;
    const SRC = this.props.src;
    const AltText = this.props.alt;

    return (
      <Fragment>
        <a href={URL}>
          <div className="overlay">
            <div className="title">
            <span className="text">
              <Content/>
            </span>
            </div>
          </div>
          <img src={SRC} alt={AltText}/>
        </a>
      </Fragment>
    );
  }
}

export default DiscoLink;
