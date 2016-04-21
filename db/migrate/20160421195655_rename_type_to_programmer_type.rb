class RenameTypeToProgrammerType < ActiveRecord::Migration
  def change
    remove_column :programmers, :type
    add_column :programmers, :programmerType, :string
  end
end
