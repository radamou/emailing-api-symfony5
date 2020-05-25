import Button from "@material-ui/core/Button";
import React from "react";

const CustomButton = ({
          push,
      basePath,
      className,
      classes,
      saving,
      invalid,
      variant,
      translate,
      handleSubmit,
      handleSubmitWithRedirect,
      submitOnEnter,
      record,
      redirect,
      resource,
      locale,
      showNotification,
      undoable,
      pristine,
      ...rest
  }) => <Button {...rest} component={"span"}/>;

export default CustomButton;